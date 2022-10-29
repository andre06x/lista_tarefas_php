<?php

require "../app_lista_tarefas/tarefa.model.php";
require "../app_lista_tarefas/tarefa.service.php";
require "../app_lista_tarefas/conexao.php";

$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
$pag = isset($_GET['pag']) ? $_GET['pag'] : 'todas_tarefas';

if($acao == 'inserir'){

$tarefa = new Tarefa();
$tarefa->__set('tarefa', $_POST['tarefa']);

$conexao = new Conexao();

$tarefaService = new TarefaService($conexao, $tarefa);
$tarefaService->inserir();

header('Location: nova_tarefa.php?inclusao=1');
} else if($acao == 'recuperar'){
    
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->recuperar();

} else if($acao == 'atualizar'){
    
    echo 'estamos aq';
    $tarefa = new Tarefa();
    $tarefa->__set('id', $_POST['id']);
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->atualizar();
    if($tarefaService->atualizar()){
        header("location:${pag}.php");
    }

} else if($acao == 'remover'){

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id']);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->remover();
    header("location:${pag}.php");

} else if($acao == 'marcarRealizada'){
    $tarefa = new Tarefa;
    $tarefa->__set('id', $_GET['id']);
    $tarefa->__set('id_status', 2);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->marcarRealizada();

    header("location:${pag}.php");

} else if($acao == 'tarefas_pendentes'){
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->tarefas_pendentes();
}
