<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'smokeice_mapa');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'smokeice_mapa');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '^ELGwFw#SNRI');

/** nome do host do MySQL */
define('DB_HOST', 'mysql592.lnxserversecure.com');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1_,ci:@I7NlX=8n__wx~Wqh(phbx|Y~IddiYeU{$nx2+%n:26}I5SyLBhcD_+-aS');
define('SECURE_AUTH_KEY',  '.tYEV!|Qm#`7,1F^:1?RE>hj}ur5o@D~B%oD55lnFcRMhm{u-t.NNR~M4>-dpc+c');
define('LOGGED_IN_KEY',    ',T^%o=MSGE~ KRJ<PT~<+@MWPP+IotY |]2G!: 1(!#4j>~c{UY2C1;,klJ6SZ>Q');
define('NONCE_KEY',        'zKd&qm6~INR_K-cE+RppOHpSbdOx*bi*&&$Payk}y1GC-(tfw[$wTm$;/sK((lB+');
define('AUTH_SALT',        '[Es(R&]!x`be/tn$q;s^>JCSn-n+5E}RH+.,1K[o41t4W0/R#V% a2+9e>CDa4+8');
define('SECURE_AUTH_SALT', 'A7eE/+RpjzDMBal|>F2yVP:Rpc[5];..Ue?$s+$-+~Dp==;TXe?!TMJb|Z8,sdo7');
define('LOGGED_IN_SALT',   '2$.VA?]8nq+}5;,BC<#qa;Pn:?RO2*Fn*~A +I:w L8Li-nuR-ugFXj-eYDD.Qbz');
define('NONCE_SALT',       'U<e>`Pp]Uh+R&,3uM`ir^[r=HF)eC7SDd ?_eCqhm|.Z6z)l 7r?8&C!0*p@~10*');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');

