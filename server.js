const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();

const locaisFile = path.join(__dirname, 'public', 'locais_estagio.json');

// Verifica se o arquivo de locais existe, caso contrário, cria um arquivo vazio
if (!fs.existsSync(locaisFile)) {
    fs.writeFileSync(locaisFile, '[]', 'utf8');  // Cria um JSON vazio
}

// Middleware para processar dados JSON
app.use(express.json());
app.use(express.static('public'));

// Função para ler os locais de estágio
function lerLocaisEstagio() {
    const data = fs.readFileSync(locaisFile, 'utf8');
    return JSON.parse(data);
}

// Função para salvar os locais no arquivo JSON
function salvarLocaisEstagio(locais) {
    fs.writeFileSync(locaisFile, JSON.stringify(locais, null, 2), 'utf8');
}

// Endpoint para obter a lista de locais
app.get('/api/locais', (req, res) => {
    try {
        const locais = lerLocaisEstagio();
        res.json(locais);
    } catch (error) {
        res.status(500).json({ message: 'Erro ao ler os locais de estágio.' });
    }
});

// Endpoint para adicionar um novo local
app.post('/api/locais', (req, res) => {
    const { nome } = req.body;

    if (!nome || nome.trim() === '') {
        return res.status(400).json({ message: 'O nome do local é obrigatório.' });
    }

    try {
        const locais = lerLocaisEstagio();
        const novoLocal = { id: Date.now(), nome };
        locais.push(novoLocal);
        salvarLocaisEstagio(locais);
        res.status(201).json(novoLocal);
    } catch (error) {
        res.status(500).json({ message: 'Erro ao adicionar o local.' });
    }
});

// Endpoint para editar um local
app.put('/api/locais/:id', (req, res) => {
    const { id } = req.params;
    const { nome } = req.body;

    if (!nome || nome.trim() === '') {
        return res.status(400).json({ message: 'O nome do local é obrigatório.' });
    }

    try {
        const locais = lerLocaisEstagio();
        const index = locais.findIndex(local => local.id === parseInt(id));

        if (index === -1) {
            return res.status(404).json({ message: 'Local não encontrado.' });
        }

        locais[index].nome = nome;
        salvarLocaisEstagio(locais);
        res.status(200).json(locais[index]);
    } catch (error) {
        res.status(500).json({ message: 'Erro ao editar o local.' });
    }
});

// Endpoint para excluir um local
app.delete('/api/locais/:id', (req, res) => {
    const { id } = req.params;

    try {
        const locais = lerLocaisEstagio();
        const novosLocais = locais.filter(local => local.id !== parseInt(id));

        if (locais.length === novosLocais.length) {
            return res.status(404).json({ message: 'Local não encontrado.' });
        }

        salvarLocaisEstagio(novosLocais);
        res.status(200).json({ message: 'Local excluído com sucesso.' });
    } catch (error) {
        res.status(500).json({ message: 'Erro ao excluir o local.' });
    }
});

// Iniciar o servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Servidor rodando na porta ${PORT}`);
});
