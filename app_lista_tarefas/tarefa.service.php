<?php 
class TarefaService {

    private $conexao;
    private $tarefa;

    public function __construct(Conexao $conexao, Tarefa $tarefa)
    {
      $this->conexao = $conexao->conectar();
      $this->tarefa  = $tarefa;           
    }
    public function inserir(){
        
        $query = 'INSERT INTO tb_tarefas(tarefa)values(:tarefa)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->execute();
    }
    
    public function recuperar(){
        $query = "
            SELECT 
                t.id, s.status, t.tarefa 
            FROM 
                tb_tarefas as t
            LEFT JOIN tb_status as s on (t.id_status = s.id)
        ";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar(){
        $query = "UPDATE tb_tarefas SET tarefa = ? where id = ?";
        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));
        return $stmt->execute();
    }

    public function remover(){
        $query = "DELETE FROM tb_tarefas where id =:id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->tarefa->__get('id'));
        $stmt->execute();
    }

    public function marcarRealizada(){
        $query = "UPDATE tb_tarefas set id_status = ? where id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->tarefa->__get('id_status'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));

        // print_r($stmt);
        return $stmt->execute();
    }

    public function tarefas_pendentes(){
        $query = "
        SELECT 
            t.id, s.status, t.tarefa 
        FROM 
            tb_tarefas as t
        LEFT JOIN tb_status as s on (t.id_status = s.id)
        WHERE t.id_status = 1
    ";
    $stmt = $this->conexao->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
