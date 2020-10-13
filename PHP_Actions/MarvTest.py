# Imports
import numpy as np
import pandas as pd
import itertools
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import PassiveAggressiveClassifier
from sklearn.metrics import accuracy_score, confusion_matrix

# Read the data
df=pd.read_csv(r"news.csv")

# Get shape
df.shape
df.head()

# DataFlair Labels
labels=df.label
labels.head()

# Setting up sets
x_train, x_test, y_train, y_test=train_test_split(df['text'], labels, test_size=0.2, random_state=7)

# Initialize TfidVectorizer
tfidf_vectorizer=TfidfVectorizer(stop_words='english', max_df=0.7)

# Fit and transform sets
tfidf_train=tfidf_vectorizer.fit_transform(x_train)
tfidf_test=tfidf_vectorizer.transform(x_test)

#Initialize Passive Aggressive Classifier
pac=PassiveAggressiveClassifier(max_iter=50)
pac.fit(tfidf_train, y_train)

# Predict on test set and calc accuracy
y_pred=pac.predict(tfidf_test)
score=accuracy_score(y_test, y_pred)
print(f'Accuracy: {round(score*100,2)}%')

# Build confusion matrix
confusion_matrix(y_test,y_pred, labels=['Fake','Real'])

