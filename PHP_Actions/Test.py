# Importing modules
from sklearn.datasets import load_iris
from sklearn.linear_model import PassiveAggressiveClassifier
from sklearn.metrics import classification_report, accuracy_score
from sklearn.model_selection import train_test_split

# Loading dataset
dataset = load_iris()
X = dataset.data
y = dataset.target

# Splitting iris dataset into train and test sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.1, random_state=13)

# Creating model
model = PassiveAggressiveClassifier(C=0.5, random_state=5)

# Fitting model
model.fit(X_train, y_train)

# Making prediction on test set
test_pred = model.predict(X_test)

# Model evaluation
print(f"Test Set Accuracy : {accuracy_score(y_test, test_pred) * 100} %\n\n")

print(f"Classification Report : \n\n{classification_report(y_test, test_pred)}")
