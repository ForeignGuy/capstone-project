
# Imports
import numpy as np
import pandas as pd
import itertools
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import PassiveAggressiveClassifier
from sklearn.metrics import accuracy_score, confusion_matrix


# Read the data
df = pd.read_csv(r"news.csv")
df1 = pd.read_csv(r"userInput.csv")

df1.shape
df1.head()

labels1 = df1.label
labels1.head()

# Get shape
df.shape
df.head()

# DataFlair Labels
labels = df.label
labels.head()

# Setting up sets
x_train, x_test, y_train, y_test = train_test_split(df['text'], labels, test_size=0.8, random_state=1165)
x_input = labels1
# print(x_test)

# Initialize TfidVectorizer
tfidf_vectorizer = TfidfVectorizer(stop_words='english', max_df=0.7)

# Fit and transform sets
tfidf_train = tfidf_vectorizer.fit_transform(x_train)
tfidf_test = tfidf_vectorizer.transform(x_test)
tfidf1_test = tfidf_vectorizer.transform(x_input)

# Initialize Passive Aggressive Classifier
pac = PassiveAggressiveClassifier(max_iter=50)
pac.fit(tfidf_train, y_train)

# Predict on test set and calc accuracy
y_pred = pac.predict(tfidf_test)
print(y_pred)
scoredefault = pac.decision_function(tfidf_test)
print(scoredefault)
score = accuracy_score(y_test, y_pred)
print(f'Accuracy: {round(score*100,2)}%')

resultPred = pac.predict(tfidf1_test)
print(resultPred)
score1 = pac.decision_function(tfidf1_test)
print(score1)
print(x_input)
