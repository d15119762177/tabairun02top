<?php

    ?
    ?/*
    ? * Filename: httpclient.php Created on 2012-12-21 Created by RobinTang To change the template for this generated file go to Window - Preferences - PHPeclipse - PHP - Code Templates
    ? */
    ?class SinCookie {
     ?public $name; // Cookie����
     ?public $value; // Cookieֵ
      ?
     ?// ����������������δʵ��
     ?public $expires; // ����ʱ��
     ?public $path; // ·��
     ?public $domain; // ��
      ?
     ?// ��Cookie�ַ�������һ��Cookie����
     ?function __construct($s = false) {
      ?if ($s) {
       ?$i1 = strpos ( $s, '=' );
       ?$i2 = strpos ( $s, ';' );
       ?$this->name = trim ( substr ( $s, 0, $i1 ) );
       ?$this->value = trim ( substr ( $s, $i1 + 1, $i2 - $i1 - 1 ) );
      ?}
     ?}
     ?// ��ȡCookie��ֵ��
     ?function getKeyValue() {
      ?return "$this->name=$this->value";
     ?}
    ?}
    ?
    ?// �Ự������
    ?class SinHttpContext {
     ?public $cookies; // �ỰCookies
     ?public $referer; // ǰһ��ҳ���ַ
     ?function __construct() {
      ?$this->cookies = array ();
      ?$this->refrer = "";
     ?}
     ?
     ?// ����Cookie
     ?function cookie($key, $val) {
      ?$ck = new SinCookie ();
      ?$ck->name = $key;
      ?$ck->value = $val;
      ?$this->addCookie ( $ck );
     ?}
     ?// ���Cookie
     ?function addCookie($ck) {
      ?$this->cookies [$ck->name] = $ck;
     ?}
     ?// ��ȡCookies�ִ�������ʱ�õ�
     ?function cookiesString() {
      ?$res = '';
      ?foreach ( $this->cookies as $ck ) {
       ?$res .= $ck->getKeyValue () . ';';
      ?}
      ?return $res;
     ?}
    ?}
    ?
    ?// Http�������
    ?class SinHttpRequest {
     ?public $url; // �����ַ
     ?public $method = 'GET'; // ���󷽷�
     ?public $host; // ����
     ?public $path; // ·��
     ?public $scheme; // Э�飬http
     ?public $port; // �˿�
     ?public $header; // ����ͷ
     ?public $body; // ��������
     ? ?
     ?// ����ͷ
     ?function setHeader($k, $v) {
      ?if (! isset ( $this->header )) {
       ?$this->header = array ();
      ?}
      ?$this->header [$k] = $v;
     ?}
     ?
     ?// ��ȡ�����ַ���
     ?// ����ͷ����������
     ?// ��ȡ֮��ֱ��дsocket����
     ?function reqString() {
      ?$matches = parse_url ( $this->url );
      ?! isset ( $matches ['host'] ) && $matches ['host'] = '';
      ?! isset ( $matches ['path'] ) && $matches ['path'] = '';
      ?! isset ( $matches ['query'] ) && $matches ['query'] = '';
      ?! isset ( $matches ['port'] ) && $matches ['port'] = '';
      ?
      ?$host = $matches ['host'];
      ?$path = $matches ['path'] ? $matches ['path'] . ($matches ['query'] ? '?' . $matches ['query'] : '') : '/';
      ?$port = ! empty ( $matches ['port'] ) ? $matches ['port'] : 80;
      ?$scheme = $matches ['scheme'] ? $matches ['scheme'] : 'http';
      ?
      ?$this->host = $host;
      ?$this->path = $path;
      ?$this->scheme = $scheme;
      ?$this->port = $port;
      ?
      ?$method = strtoupper ( $this->method );
      ?$res = "$method $path HTTP/1.1\r\n";
      ?$res .= "Host: $host\r\n";
      ?
      ?if ($this->header) {
       ?reset ( $this->header );
       ?while ( list ( $k, $v ) = each ( $this->header ) ) {
        ?if (isset ( $v ) && strlen ( $v ) > 0)
         ?$res .= "$k: $v\r\n";
       ?}
      ?}
      ?$res .= "\r\n";
      ?if ($this->body) {
       ?$res .= $this->body;
       ?$res .= "\r\n\r\n";
      ?}
      ?return $res;
     ?}
    ?}
    ?
    ?// Http��Ӧ
    ?class SinHttpResponse {
     ?public $scheme; // Э��
     ?public $stasus; // ״̬���ɹ���ʱ����ok
     ?public $code; // ״̬�룬�ɹ���ʱ����200
     ?public $header; // ��Ӧͷ
     ?public $body; // ��Ӧ����
     ?function __construct() {
      ?$this->header = array ();
      ?$this->body = null;
     ?}
     ?function setHeader($key, $val) {
      ?$this->header [$key] = $val;
     ?}
    ?}
    ?
    ?// HttpClient
    ?class SinHttpClient {
     ?public $keepcontext = true; // �Ƿ�ά�ֻỰ
     ?public $context; // ������
     ?public $request; // ����
     ?public $response; // ��Ӧ
     ?public $debug = false; // �Ƿ���Debugģʽ��Ϊtrue��ʱ����ӡ���������ݺ���ͬ��ͷ��
     ?function __construct() {
      ?$this->request = new SinHttpRequest ();
      ?$this->response = new SinHttpResponse ();
      ?$this->context = new SinHttpContext ();
      ?$this->timeout = 15; // Ĭ�ϵĳ�ʱΪ15s
     ?}
     ?
     ?// �����һ�ε���������
     ?function clearRequest() {
      ?$this->request->body = '';
      ?$this->request->setHeader ( 'Content-Length', false );
      ?$this->request->setHeader ( 'Content-Type', false );
     ?}
     ?// post����
     ?// dataΪ���������
     ?// Ϊ��ֵ�Ե�ʱ��ģ����ύ
     ?// ����ʱ��Ϊ�����ύ���ύ����ʽΪxml
     ?// ��������������������չ
     ?function post($url, $data = false) {
      ?$this->clearRequest ();
      ?if ($data) {
       ?if (is_array ( $data )) {
        ?$con = http_build_query ( $data );
        ?$this->request->setHeader ( 'Content-Type', 'application/x-www-form-urlencoded' );
       ?} else {
        ?$con = $data;
        ?$this->request->setHeader ( 'Content-Type', 'text/xml; charset=utf-8' );
       ?}
       ?$this->request->body = $con;
       ?$this->request->method = "POST";
       ?$this->request->setHeader ( 'Content-Length', strlen ( $con ) );
      ?}
      ?$this->startRequest ( $url );
     ?}
     ?// get����
     ?function get($url) {
      ?$this->clearRequest ();
      ?$this->request->method = "GET";
      ?$this->startRequest ( $url );
     ?}
     ?// �÷���Ϊ�ڲ����÷���������ֱ�ӵ���
     ?function startRequest($url) {
      ?$this->request->url = $url;
      ?if ($this->keepcontext) {
       ?// ������������ĵĻ����������Ϣ
       ?$this->request->setHeader ( 'Referer', $this->context->refrer );
       ?$cks = $this->context->cookiesString ();
       ?if (strlen ( $cks ) > 0)
        ?$this->request->setHeader ( 'Cookie', $cks );
      ?}
      ?// ��ȡ��������
      ?$reqstring = $this->request->reqString ();
      ?if ($this->debug)
       ?echo "Request:\n$reqstring\n";
      ?try {
       ?$fp = fsockopen ( $this->request->host, $this->request->port, $errno, $errstr, $this->timeout );
      ?} catch ( Exception $ex ) {
       ?echo $ex->getMessage ();
       ?exit ( 0 );
      ?}
      ?if ($fp) {
       ?stream_set_blocking ( $fp, true );
       ?stream_set_timeout ( $fp, $this->timeout );
       ?// д����
       ?fwrite ( $fp, $reqstring );
       ?$status = stream_get_meta_data ( $fp );
       ?if (! $status ['timed_out']) { // δ��ʱ
       ? // �����ѭ��������ȡ��Ӧͷ��
        ?while ( ! feof ( $fp ) ) {
         ?$h = fgets ( $fp );
         ?if ($this->debug)
          ?echo $h;
         ?if ($h && ($h == "\r\n" || $h == "\n"))
          ?break;
         ?$pos = strpos ( $h, ':' );
         ?if ($pos) {
          ?$k = strtolower ( trim ( substr ( $h, 0, $pos ) ) );
          ?$v = trim ( substr ( $h, $pos + 1 ) );
          ?
          ?if ($k == 'set-cookie') {
           ?// ����Cookie
           ?if ($this->keepcontext) {
            ?$this->context->addCookie ( new SinCookie ( $v ) );
           ?}
          ?} else {
           ?// ��ӵ�ͷ����ȥ
           ?$this->response->setHeader ( $k, $v );
          ?}
         ?} else {
          ?// ��һ������
          ?// ������Ӧ״̬
          ?$preg = '/^(\S*) (\S*) (.*)$/';
          ?preg_match_all ( $preg, $h, $arr );
          ?isset ( $arr [1] [0] ) & $this->response->scheme = trim ( $arr [1] [0] );
          ?isset ( $arr [2] [0] ) & $this->response->stasus = trim ( $arr [2] [0] );
          ?isset ( $arr [3] [0] ) & $this->response->code = trim ( $arr [3] [0] );
         ?}
        ?}
        ?// ��ȡ��Ӧ���ĳ���
        ?$len = ( int ) $this->response->header ['content-length'];
        ?$res = '';
        ?// �����ѭ����ȡ����
        ?while ( ! feof ( $fp ) && $len > 0 ) {
         ?$c = fread ( $fp, $len );
         ?$res .= $c;
         ?$len -= strlen ( $c );
        ?}
        ?$this->response->body = $res;
       ?}
       ?// �ر�Socket
       ?fclose ( $fp );
       ?// �ѷ��ر��浽������ά����
       ?$this->context->refrer = $url;
      ?}
     ?}
    ?}
    ?
    ?// demo
    ?// now let begin test it
    ?$client = new SinHttpClient (); // create a client
    ?$client->get ( 'http://qzone.qq.com/' ); // get
    ?
    ?$body = $client->response->body;
    ?echo $body; // echo
    >? 
