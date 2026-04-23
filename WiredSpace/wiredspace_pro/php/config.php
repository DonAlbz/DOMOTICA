<?php
// WiredSpace S.r.l. — config.php | Progetto GPOI 2024/2025
define('DB_HOST','localhost');define('DB_USER','root');define('DB_PASS','');define('DB_NAME','wiredspace_pro');define('DB_CHARSET','utf8mb4');
function getDB():PDO{static $p=null;if($p===null){try{$p=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET,DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}catch(PDOException $e){die('<div style="font-family:system-ui;max-width:580px;margin:3rem auto;padding:2rem;background:#fef2f2;border:1px solid #fecaca;border-radius:12px"><h2 style="color:#dc2626;margin-bottom:.75rem">⚠️ Errore connessione database</h2><p>'.$e->getMessage().'</p><p style="margin-top:.75rem;color:#666">Verifica che MySQL sia avviato e le credenziali in <code>php/config.php</code> siano corrette.<br>Nome database atteso: <strong>wiredspace_pro</strong></p></div>');}}return $p;}
if(session_status()===PHP_SESSION_NONE)session_start();
function auth():bool{return isset($_SESSION['uid']);}
function isAdmin():bool{return($_SESSION['ruolo']??'')==='admin';}
function isTecnico():bool{return in_array($_SESSION['ruolo']??'',['admin','tecnico']);}
function requireAuth(string $r='../php/login.php'):void{if(!auth()){header("Location:$r");exit;}}
function esc(string $s):string{return htmlspecialchars($s,ENT_QUOTES,'UTF-8');}
