from flask import Flask, send_from_directory
import os

app = Flask(__name__)

# Rota para servir arquivos
@app.route('/<path:filename>')
def serve_file(filename):
    # Serve arquivos do diretório especificado
    return send_from_directory('sistema_estagio_2024/pmnf_smcti_estagio', filename)

if __name__ == '__main__':
    # Executa o servidor na porta 9090
    app.run(host='0.0.0.0', port=9090)
