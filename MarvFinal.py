#! C:\Users\Jacob Baum\anaconda3\python.exe

# import packages

import numpy as np
import torch.utils.data as data_utils
import torch.optim as optim
import gc
from tqdm import tqdm
import torch.nn as nn
import torch
import pandas as pd
from transformers import BertForSequenceClassification, BertTokenizer
import sys

# ----------Training Code Block Start---------------------------------------------
# initialize device to use CUDA or CPU

PATH = "state_dict_model.pt"
device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
# device = torch.device("cpu")
# setup data frame for training data set

# trainingDataFrame = pd.read_csv("newsUpdated.csv")
# trainingDataFrame.columns = ['text', 'label', 'class']

# tokenizer type that Bert will use

tokenizer = BertTokenizer.from_pretrained('bert-base-uncased')

# function for applying tokenizer to a data frame


def tokenize(dataframe):
    tokenized_dataframe = list(map(lambda t: ['[CLS]'] + tokenizer.tokenize(t)[:510] + ['[SEP]'], dataframe['text']))
    return tokenized_dataframe


# total length limiter

totalLength = 512

# functions for indexing the tokens of a dataframe


def index_tokens(tokenized_dataframe):
    indexed_token = list(map(tokenizer.convert_tokens_to_ids, tokenized_dataframe))
    return indexed_token

# function for pad length of tokenized dataframe


def index_padding(indexed_token):
    index_padded = np.array([xi+[0]*(totalLength-len(xi)) for xi in indexed_token])
    return index_padded


# collect the labels (from the training dataframe) that will be used in the calculation


# trainingClassification = trainingDataFrame['class'].values
# trainingText = trainingDataFrame.text

# use functions to tokenize, index, and pad

# trainingTokenized = tokenize(trainingDataFrame)
# trainingIndexed = index_tokens(trainingTokenized)
# trainingPadded = index_padding(trainingIndexed)

# all_words = []
# for l in trainingTokenized:
#     all_words.extend(l)
# all_indices = []
# for i in trainingIndexed:
#     all_indices.extend(i)
#
# word_to_ix = dict(zip(all_words, all_indices))
# ix_to_word = dict(zip(all_indices, all_words))
#
# mask_variable = [[float(i > 0) for i in ii] for ii in trainingPadded]

# set the batch size and define the function to format the tensor loader

batchSize = 1


def tensor_loader(text, mask, loader_labels, loader_batch):
    x = torch.from_numpy(text)
    x = x.long()
    mask = torch.tensor(mask)
    y = torch.from_numpy(loader_labels)
    y = y.long()
    tensor_data = data_utils.TensorDataset(x, mask, y)
    loader = data_utils.DataLoader(tensor_data, batch_size=loader_batch, shuffle=False)
    return loader


# establish train variables for the x and y

# x_train = trainingPadded
# y_train = trainingClassification
# train_mask = mask_variable

# Use the tensor loader function to load the training set

# trainLoader = tensor_loader(x_train, train_mask, y_train, batchSize)
#
# torch.cuda.empty_cache()
# gc.collect()
# epochNum = 1
# loss_function = nn.BCEWithLogitsLoss()
# losses = []
# model = BertForSequenceClassification.from_pretrained('bert-base-uncased')
# model.to(device)
# optimizer = optim.Adam(model.parameters(), lr=3e-6)
# for epoch in range(epochNum):
#     model.train()
#     running_loss = 0.0
#     iteration = 0
#     for i, batch in enumerate(trainLoader):
#         iteration += 1
#         token_ids, masks, labels = tuple(t.to(device) for t in batch)
#         optimizer.zero_grad()
#         loss, yhat = model(input_ids=token_ids, attention_mask=masks, labels=labels)
#         loss.backward()
#         optimizer.step()
#         running_loss += float(loss.item())
#         del token_ids, masks, labels
#         if not i % 25:
#             running_loss = 0.0
#             iteration = 0
#         torch.cuda.empty_cache()
#         gc.collect()
#         losses.append(float(loss.item()))
# torch.save(model, PATH)
# ---------------Training Code Block End-------------------------------------------


model = torch.load(PATH)
checkCondition = 'default'

checkCondition = " ".join(sys.argv[5:])
print("Your input was: " + checkCondition)
data = {'text': [checkCondition], 'label': ['FAKE'], 'class': [0]}
inputDataFrame = pd.DataFrame(data, columns=['text', 'label', 'class'])

inputClassification = inputDataFrame["class"].values
inputDataFrame.text

inputTokenized = tokenize(inputDataFrame)
inputIndexed = index_tokens(inputTokenized)
inputPadded = index_padding(inputIndexed)

all_words = []
for l in inputTokenized:
    all_words.extend(l)
all_indices = []
for i in inputIndexed:
    all_indices.extend(i)

word_to_ix = dict(zip(all_words, all_indices))
ix_to_word = dict(zip(all_indices, all_words))

mask_variable_input = [[float(i > 0) for i in ii] for ii in inputPadded]

x_input = inputPadded
y_input = inputClassification
input_mask = mask_variable_input

inputLoader = tensor_loader(x_input, input_mask, y_input, batchSize)

input_percentCon = torch.zeros((len(y_input), 1))
input_prediction = torch.zeros((len(y_input), 1))

with torch.no_grad():
    for i, batch in enumerate(tqdm(inputLoader)):
        token_ids, masks, labels = tuple(t.to(device) for t in batch)
        _, yhat = model(input_ids=token_ids, attention_mask=masks, labels=labels)
        prediction = (torch.sigmoid(yhat[:, 1]) > 0.5).long().view(-1, 1)
        input_prediction[i*batchSize:(i+1)*batchSize] = prediction
        input_percentCon[i*batchSize:(i+1)*batchSize] = torch.sigmoid(yhat[:, 1].view(-1, 1))

percentCon = np.array(input_percentCon.reshape(-1), dtype=float)
prediction = np.array(input_prediction.reshape(-1), dtype=int)

if prediction == 1:
    print("REAL")
else:
    print("FAKE")
if percentCon >= 0.50:
    print("Marv is confident in this answer")
else:
    print("Marv is not as confident in this answer")



