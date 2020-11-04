
# Imports
import numpy as np
import pandas as pd
import itertools
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import PassiveAggressiveClassifier
from sklearn.metrics import accuracy_score, confusion_matrix
from random import randint

# max_columns to view the whole string.
pd.set_option('display.max_columns', None)
pd.set_option('display.expand_frame_repr', False)
# dont worry about the futureWarning Error.
pd.set_option('max_colwidth', -1)

# the default configuration i'm pushing this code in is to calculate an accuracy percentage between two
# unrelated data sets. It can do the other tests by uncommenting code blocks
# Read the data
# 40,000 news articles
df = pd.read_csv(r"theOmega.csv")
# original data of 7,000
df1 = pd.read_csv(r"news.csv")

df1.shape
df1.head()

# Get shape
df.shape
df.head()

# find and replace code to get rid of a few phrases in the beeg data set. Dont worry about this it works great
# dfm = [df['text'][i].replace('WASHINGTON (Reuters) - ', '').replace('LONDON (Reuters) - ', '').replace('(Reuters) - ', '') for i in range(len(df['text']))]
# df['text'] = dfm

# piece of test code to print the first entry in the test. If your using userInput.csv, it'll print the user input
# print(df1['text'][0])

# this is commented out placeholder code for splitting the dataset, don't use if your using the below code
x_train, x_test, y_train, y_test = train_test_split(df['text'], df['label'], test_size=0.5, random_state=randint(0, 40000))
print(x_test)

# new xtrain and ytrain variable definitions. The dataset is not split using these, don't use if you're splitting
# the dataset
# x_train = df['text']    # df text refers to the text column of the dataframe defined above
# y_train = df['label']   # df label refers to the label column of the dataframe defined above

# Initialize TfidVectorizer
tfidf_vectorizer = TfidfVectorizer(stop_words='english', max_df=0.7)

# Fit and transform sets
tfidf_train = tfidf_vectorizer.fit_transform(x_train)
tfidf_test = tfidf_vectorizer.transform(df1['text'])
# use this code line below if your using the split data set, comment out the one above if you are
# tfidf_test = tfidf_vectorizer.transform(x_test)

# Initialize Passive Aggressive Classifier
pac = PassiveAggressiveClassifier(max_iter=50)
pac.fit(tfidf_train, y_train)

# the code block below is for the different outputs you can get
# the pac.predict lines are for prediciting and there are the different things you can print out beneath it
# its currently commented out because i was testing percent accuracy

# y_pred = pac.predict(tfidf_test)
# print(y_pred)
# scoredefault = pac.decision_function(tfidf_test)
# print(scoredefault)

# score = accuracy_score(y_test,y_pred)
# print(f'Accuracy: {round(score*100,2)}%')

# this is a function i stole from online and modified to do what i want
# it should make a vector of the new input and run the pac on it
# i also stole the if statement uncreditly for testing purposes
# should compare the label it just predicted with the label thats actually in df1 and assign a one if they're the same
# then all the ones are summed and divided by the size of df1 to get the accuracy percentage
# if you guys see an error in this testing methodology please let me know or change it because it is the basis of
# my results


def findlabel(newtext):
    vec_newtest=tfidf_vectorizer.transform([newtext])
    y_pred1 = pac.predict(vec_newtest)
    return y_pred1[0]


percent = sum([1 if findlabel((df1['text'][i])) == df1['label'][i] else 0 for i in range(len(df1['text']))])/df1['text'].size
print(percent)