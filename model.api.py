from flask import Flask, request, jsonify
import numpy as np
from sklearn.linear_model import LinearRegression

app = Flask(__name__)
# Créer un modèle de régression linéaire
model = LinearRegression()

# route /predict 
@app.route('/predict', methods=['POST'])
def predict_price():
    data = request.get_json()
    data_train = data['data_train']
    taille = data['taille']
    poids = data['poids']

    data_train = np.array(data_train)
    X = data_train[:, 1:]  # Caractéristiques : taille et poids
    y = data_train[:, 0]   # Étiquette : prix
    model.fit(X, y)

    new_data = np.array([[taille, poids]])
    prix = model.predict(new_data)
    return jsonify({'price': prix[0]})

if __name__ == '__main__':
    app.run()
