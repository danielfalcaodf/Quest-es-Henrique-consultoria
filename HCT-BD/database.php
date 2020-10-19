<?php

class Banco
{


    private $log;
    public function __construct()
    {
        $log = $this->createTable(
            'cadastro',
            [
                'id int(4) NOT NULL',
                'nome varchar (35) not null',
                'email varchar (25) not null',
                'cidade varchar (25)not null',
                'estado varchar (2) not null',
                'comentarios text not null'
            ]
        );
        $this->log['Questao 7'] = $log;
    }
    public function getLog()
    {
        return    $this->log;
    }


    /**
     * @return [type]
     */
    private function connect_db()
    {
        try {




            $whitelist = array('127.0.0.1', "::1", 'localhost');
            $conn = '';
            if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
                $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
            } else {
                $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                //DB credentials


            }

            mysqli_query($conn, "SET NAMES 'utf8'");
            mysqli_query($conn, 'SET character_set_connection=utf8');
            mysqli_query($conn, 'SET character_set_client=utf8');
            mysqli_query($conn, 'SET character_set_results=utf8');
            return $conn;
        } catch (Exception $e) {
            return null;
        }
    }
    private function destroy_db($conn)
    {
        mysqli_close($conn);
    }

    /**
     * @param mixed $table
     * @param mixed $data
     * 
     * @return [type]
     */
    public function insertDB($table, $data)
    {
        $log['type'] = 'insert';

        if (count($data) > 0) {
            $conn = $this->connect_db();

            if ($conn != null) {
                $colunas = array();
                $values = array();

                foreach ($data as $coluna => $value) {
                    $colunas[] = mysqli_real_escape_string($conn, trim($coluna));
                    $values[] = "'" . mysqli_real_escape_string($conn, trim($value)) . "'";
                }

                $colunas = implode(', ', $colunas);
                $values = implode(', ', $values);

                $sql = "INSERT INTO $table ($colunas) VALUES ($values)";
                $conn->query("SET CHARACTER SET utf8");
                $result = $conn->query($sql);

                if ($result) {
                    $log['cod'] = 1;
                    $log['id'] = $conn->insert_id;
                    $log['id_format'] = str_pad($log['id'], 4, "0", STR_PAD_LEFT);
                    // logAction($conn, $table, $log['id'], 1);
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao cadastrar no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
                $this->destroy_db($conn);
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao se conectar com o banco de dados';
            }
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Nenhum dado para inserção';
        }
        return $log;
    }

    /**
     * @param mixed $table
     * @param mixed $id
     * 
     * @return [type]
     */
    public function deleteDB($table, $id)
    {
        $log['type'] = 'delete';

        if ($id > 0) {
            $conn = $this->connect_db();

            if ($conn != null) {
                $sql = "UPDATE $table SET ativado = 1 WHERE id = '$id'";
                $result = $conn->query($sql);

                if ($result) {
                    $log['cod'] = 1;
                    // logAction($conn, $table, $id, 3);
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao deletar no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
                $this->destroy_db($conn);
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao se conectar com o banco de dados';
            }
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Nenhum dado para deletar';
        }
        return $log;
    }

    /**
     * @param mixed $table
     * @param mixed $data
     * @param mixed $where
     * 
     * @return [type]
     */
    public function updateDB($table, $data, $where)
    {
        $log['type'] = 'update';

        if (count($data) > 0) {
            $conn = $this->connect_db();

            if ($conn != null) {
                $values = array();
                $wheres = array();

                foreach ($data as $coluna => $value) {
                    if (!is_array($value)) {
                        $values[] = "$coluna = '" . mysqli_real_escape_string($conn, trim($value)) . "'";
                    }
                }
                $values = implode(', ', $values);

                foreach ($where as $coluna => $value) {
                    if (!is_array($value)) {
                        $wheres[] = "$coluna = '" . mysqli_real_escape_string($conn, trim($value)) . "'";
                    }
                }
                $log['data'] = $values;
                $log['where'] = $wheres;

                $wheres = implode(' AND ', $wheres);

                $sql = "UPDATE $table SET $values WHERE $wheres";
                $result = $conn->query($sql);

                if ($result) {
                    $log['cod'] = 1;

                    $createLog['data'] = $data;
                    $createLog['where'] = $where;
                    //logAction($conn, $table, 1, 2, $createLog);
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao cadastrar no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
                $this->destroy_db($conn);
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao se conectar com o banco de dados';
            }
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Nenhum dado para inserção';
        }
        return $log;
    }

    /**
     * @param mixed $table
     * @param array $where
     * @param array $order
     * 
     * @return [type]
     */
    public function selectDB($table, $where = array(), $order = array())
    {
        $log['type'] = 'select';

        $conn = $this->connect_db();

        if ($conn != null) {
            $wheres = array();
            if (is_array($where) and count($where) > 0) {
                foreach ($where as $coluna => $value) {
                    if (!is_array($value)) {
                        $wheres[] = "$coluna = '" . mysqli_real_escape_string($conn, trim($value)) . "'";
                    }
                }
            }
            $log['where'] = $wheres;
            $wheres = implode(' AND ', $wheres);

            $orders = array();
            if (is_array($order) and count($order) > 0) {
                foreach ($order as $coluna => $value) {
                    if (!is_array($value)) {
                        $value = mysqli_real_escape_string($conn, trim($value));
                        $value = ($value == true || $value == 'ASC') ? 'ASC' : 'DESC';
                        $orders[] = $coluna . ' ' . $value;
                    }
                }
            }
            $log['order'] = $orders;
            $orders = implode(', ', $orders);



            $sql = "SELECT * FROM $table";
            if ($wheres != '') {
                $sql .= ' WHERE ' . $wheres;
            }
            if ($orders != '') {
                $sql .= ' ORDER BY ' . $orders;
            }
            $result = $conn->query($sql);
            $log['result'] = array();

            if ($result) {
                $log['cod'] = 1;

                while ($dado = mysqli_fetch_assoc($result)) {
                    if (@$dado['id']) {
                        $dado['id_format'] = str_pad($dado['id'], 4, "0", STR_PAD_LEFT);
                    }
                    $log['result'][] = $dado;
                }
                if (empty($log['result'])) {
                    $log['cod'] = 0;
                    $log['message'] = 'Não encontrado';
                }
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao buscar no banco de dados';
                $log['error'] = mysqli_error($conn);
            }
            $this->destroy_db($conn);
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Erro ao se conectar com o banco de dados';
        }
        return $log;
    }
    public function createTable($table, $attrs = array()): array
    {
        $log['type'] = 'create';

        $conn = $this->connect_db();
        if ($conn != null) {

            if (is_array($attrs) and count($attrs) > 0) {

                $attrs =  implode(',', $attrs);
                $log['attr'] = $attrs;
                $sql = "CREATE TABLE $table ($attrs)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

                $result = $conn->query($sql);


                if ($result) {
                    $log['cod'] = 1;
                    $log['message'] = 'Tabela Criada!';
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao criar a tabela no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Array vazio ou array multi';
            }


            $this->destroy_db($conn);
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Erro ao se conectar com o banco de dados';
        }
        return $log;
    }


    /**
     * @param mixed $table
     * @param array $where
     * 
     * @return [type]
     */
    public function forceDeleteWhereDB($table, $where = array())
    {
        $log['type'] = 'delete';

        if (count($where) > 0) {
            $conn = $this->connect_db();

            if ($conn != null) {
                $wheres = array();

                foreach ($where as $coluna => $value) {
                    if (!is_array($value)) {
                        $wheres[] = "$coluna = '" . mysqli_real_escape_string($conn, trim($value)) . "'";
                    }
                }
                $log['where'] = $wheres;

                $wheres = implode(' AND ', $wheres);

                $sql = "DELETE FROM $table WHERE $wheres";
                $result = $conn->query($sql);

                if ($result) {
                    $log['cod'] = 1;
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao deletar no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
                $this->destroy_db($conn);
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao se conectar com o banco de dados';
            }
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Nenhum dado para deletar';
        }
        return $log;
    }


    /**
     * @param mixed $table
     * @param mixed $id
     * 
     * @return [type]
     */
    public function forceDeleteDB($table, $id)
    {
        $log['type'] = 'delete';

        if ($id > 0) {
            $conn = $this->connect_db();

            if ($conn != null) {
                $sql = "DELETE FROM $table WHERE id = '$id'";
                $result = $conn->query($sql);

                if ($result) {
                    $log['cod'] = 1;
                } else {
                    $log['cod'] = 0;
                    $log['message'] = 'Erro ao deletar no banco de dados';
                    $log['error'] = mysqli_error($conn);
                }
                $this->destroy_db($conn);
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao se conectar com o banco de dados';
            }
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Nenhum dado para deletar';
        }
        return $log;
    }


    /**
     * @param mixed $sql
     * 
     * @return [type]
     */
    public function selectQueryDB($sql)
    {
        $log['type'] = 'select';

        $conn = $this->connect_db();

        if ($conn != null) {
            $result = $conn->query($sql);
            $log['result'] = array();

            if (@$result) {


                while ($dado = mysqli_fetch_assoc($result)) {
                    if (@$dado['id']) {
                        $dado['id_format'] = str_pad($dado['id'], 4, "0", STR_PAD_LEFT);
                    }
                    $log['result'][] = $dado;
                }
                if (empty($log['result'])) {
                    $log['cod'] = 0;
                    $log['message'] = 'Não encontrado';
                } else {
                    $log['cod'] = 1;
                }
            } else {
                $log['cod'] = 0;
                $log['message'] = 'Erro ao buscar no banco de dados';
                $log['error'] = mysqli_error($conn);
            }
            $this->destroy_db($conn);
        } else {
            $log['cod'] = 0;
            $log['message'] = 'Erro ao se conectar com o banco de dados';
        }
        return $log;
    }
}