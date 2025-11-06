
<script setup lang="ts"></script>


<template>
  <div class="container-fluid py-4">
  <div class="mx-auto" style="max-width: 1200px;">
    <h1 class="text-center mb-4">Agenda de Contatos</h1>

    <form @submit.prevent="salvarContato" class="card p-3 mb-4 shadow-sm">
      <div class="row g-2">
        <div class="col-md-6">
          <input v-model="form.Nome" type="text" class="form-control" placeholder="Nome" required />
        </div>
        <div class="col-md-6">
          <input v-model="form.Email" type="email" class="form-control" placeholder="E-mail" required />
        </div>
        <div class="col-md-8">
          <input v-model="form.Endereco" type="text" class="form-control" placeholder="Endereço" required />
        </div>
        <div class="col-md-4">
          <input v-model="form.Telefone" type="text" class="form-control" placeholder="Telefone" required />
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          {{ editando ? 'Atualizar' : 'Adicionar' }}
        </button>
        <button v-if="editando" type="button" class="btn btn-secondary" @click="cancelarEdicao">
          Cancelar
        </button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th style="width: 15%">Nome</th>
            <th style="width: 20%">E-mail</th>
            <th style="width: 35%">Endereço</th>
            <th style="width: 15%">Telefone</th>
            <th class="text-center" style="width: 15%">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contato in contatos" :key="contato.id">
            <td class="text-truncate" style="max-width: 180px;">{{ contato.Nome }}</td>
            <td class="text-truncate" style="max-width: 220px;">{{ contato.Email }}</td>
            <td class="text-truncate" style="max-width: 350px;">{{ contato.Endereco }}</td>
            <td class="text-truncate" style="max-width: 150px;">{{ contato.Telefone }}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-warning me-2" @click="editarContato(contato)">Editar</button>
              <button class="btn btn-sm btn-danger" @click="excluirContato(contato.id)">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="erro" class="alert alert-danger mt-3">{{ erro }}</div>
    <div v-if="mensagem" class="alert alert-success mt-3">{{ mensagem }}</div>
  </div>
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