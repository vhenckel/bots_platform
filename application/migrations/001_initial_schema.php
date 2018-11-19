<?php
class Migration_Initial_schema extends CI_Migration {
    public function up()
    {
        $this->add_table_sessions();
        $this->add_table_usuarios();
    }

    public function down()
    {
        $this->dbforge->drop_table('ci_sessions');
        $this->dbforge->drop_table('usuarios');
    }

    private function add_table_sessions()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
                'auto_increment' => true
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => 45
            ),
            'timestamp' => array(
                'type' => 'INT'
            ),
            'data' => array(
                'type' => 'BLOB'
            ),
        ));

        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('ci_sessions');
    }

    private function add_table_usuarios()
    {
        $this->dbforge->add_field(array(
            'usuarioID' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'usuario' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'senha' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'status' => array(
                'type' => 'BOOLEAN'
            ),
        ));
        $this->dbforge->add_key('usuarioID', true);
        $this->dbforge->create_table('usuarios');

        $data[] = array(
            'nome'    => 'Administrador',
            'usuario' => 'admin',
            'senha'   => sha1('lead@' . 'admin' . '@force'),
            'email'   => 'admin@leadforce.com.br',
            'status'  => 1
            );

        $this->db->insert_batch('usuarios', $data);
    }
}