<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contato;

class ContatoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cria_um_contato()
    {
        $data = [
            'Nome' => 'João da Silva',
            'Email' => 'joao@example.com',
            'Endereco' => 'Rua A, 123',
            'Telefone' => '99999-9999'
        ];

        $response = $this->postJson('/api/criarContato', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['Nome' => 'João da Silva']);

        $this->assertDatabaseHas('contatos', ['Email' => 'joao@example.com']);
    }

    /** @test */
    public function lista_contatos()
    {
        Contato::factory()->count(3)->create();

        $response = $this->getJson('/api/contatos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function atualiza_um_contato()
    {
        $contato = Contato::factory()->create();

        $data = ['Nome' => 'Nome Atualizado'];

        $response = $this->putJson("/api/atualizarContato/{$contato->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['Nome' => 'Nome Atualizado']);

        $this->assertDatabaseHas('contatos', ['id' => $contato->id, 'Nome' => 'Nome Atualizado']);
    }

    /** @test */
    public function exclui_um_contato()
    {
        $contato = Contato::factory()->create();

        $response = $this->deleteJson("/api/excluirContato/{$contato->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('contatos', ['id' => $contato->id]);
    }
}
