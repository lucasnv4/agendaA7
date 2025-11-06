
<script setup lang="ts"></script>

<template>
  <div class="container">
    <h1>Agenda de Contatos</h1>

    <form @submit.prevent="salvarContato">
      <input v-model="form.Nome" placeholder="Nome" required />
      <input v-model="form.Email" placeholder="E-mail" required />
      <input v-model="form.Endereco" placeholder="Endereço" required />
      <input v-model="form.Telefone" placeholder="Telefone" required />
      <button type="submit">{{ editando ? 'Atualizar' : 'Adicionar' }}</button>
      <button type="button" v-if="editando" @click="cancelarEdicao">Cancelar</button>
    </form>

    <hr />

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Endereço</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="contato in contatos" :key="contato.id">
          <td>{{ contato.Nome }}</td>
          <td>{{ contato.Email }}</td>
          <td>{{ contato.Endereco }}</td>
          <td>{{ contato.Telefone }}</td>
          <td>
            <button @click="editarContato(contato)">Editar</button>
            <button @click="excluirContato(contato.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="erro" style="color:red">{{ erro }}</p>
    <p v-if="mensagem" style="color:green">{{ mensagem }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { api } from "./services/api";

const contatos = ref([]);
const form = ref({ nome: "", email: "", endereco: "", telefone: "" });
const editando = ref(false);
const idEditando = ref(null);
const erro = ref("");
const mensagem = ref("");

async function carregarContatos() {
  try {
    const res = await api.get("/contatos");
    contatos.value = res.data;
  } catch {
    erro.value = "Falha ao carregar contatos";
  }
}

async function salvarContato() {
  try {
    erro.value = "";
    mensagem.value = "";

    if (editando.value) {
      await api.put(`/atualizarContato/${idEditando.value}`, form.value);
      mensagem.value = "Contato atualizado com sucesso";
    } else {
      await api.post("/criarContato", form.value);
      mensagem.value = "Contato adicionado com sucesso";
    }

    form.value = { nome: "", email: "", endereco: "", telefone: "" };
    editando.value = false;
    idEditando.value = null;
    carregarContatos();
  } catch {
    erro.value = "Erro ao salvar contato";
  }
}

function editarContato(contato) {
  form.value = { ...contato };
  editando.value = true;
  idEditando.value = contato.id;
}

async function excluirContato(id) {
  try {
    await api.delete(`/excluirContato/${id}`);
    mensagem.value = "Contato excluído";
    carregarContatos();
  } catch {
    erro.value = "Erro ao excluir contato";
  }
}

function cancelarEdicao() {
  form.value = { nome: "", email: "", endereco: "", telefone: "" };
  editando.value = false;
  idEditando.value = null;
}

onMounted(carregarContatos);
</script>

<style>
.container {
  width: 600px;
  margin: 20px auto;
  font-family: sans-serif;
}

form {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 15px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ccc;
  padding: 6px;
  text-align: left;
}
</style>