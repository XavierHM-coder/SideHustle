<?php

/* =========================================================
   SIDEHUSTLE — CONTACT FORM
   Envía:
   1. Notificación interna a SideHustle
   2. Confirmación al cliente
========================================================= */


/* =========================================================
   CONFIGURACIÓN
========================================================= */

// CORREO QUE RECIBIRÁ LAS SOLICITUDES
$sidehustleEmail = "sidehustleadma@gmail.com";

// CORREO DESDE EL QUE SE ENVÍAN LOS MENSAJES
// Debe existir en tu hosting/dominio.
$fromEmail = "sidehustleadma@gmail.com";

// URL PRINCIPAL DEL SITIO
$siteUrl = "https://side-hustle-indol.vercel.app";

// URL DEL LOGO
$logoUrl = $siteUrl . "/assets/img/logo2.png";


/* =========================================================
   SOLO ACEPTAR POST
========================================================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.html");
    exit;
}


/* =========================================================
   RECIBIR DATOS
========================================================= */

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");


/* =========================================================
   VALIDACIÓN
========================================================= */

if (
    $name === "" ||
    $email === "" ||
    $service === "" ||
    $message === ""
) {
    header("Location: contact.html?error=1");
    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.html?error=2");
    exit;
}


/* =========================================================
   SEGURIDAD PARA HTML
========================================================= */

$nameSafe = htmlspecialchars($name, ENT_QUOTES, "UTF-8");
$emailSafe = htmlspecialchars($email, ENT_QUOTES, "UTF-8");
$phoneSafe = htmlspecialchars(
    $phone !== "" ? $phone : "Not provided",
    ENT_QUOTES,
    "UTF-8"
);
$serviceSafe = htmlspecialchars($service, ENT_QUOTES, "UTF-8");
$messageSafe = nl2br(
    htmlspecialchars($message, ENT_QUOTES, "UTF-8")
);


/* =========================================================
   FECHA
========================================================= */

$date = date("F j, Y");
$time = date("g:i A");


/* =========================================================
   EMAIL #1
   NOTIFICACIÓN PARA SIDEHUSTLE
========================================================= */

$internalSubject = "New SideHustle Project Inquiry — " . $service;


/* ---------- HTML INTERNO ---------- */

$internalBody = <<<HTML
<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>New SideHustle Inquiry</title>

</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f3ef;
    font-family:Arial,Helvetica,sans-serif;
    color:#0d1220;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
style="background:#f4f3ef;padding:40px 15px;">

<tr>

<td align="center">

<table width="600" cellpadding="0" cellspacing="0" border="0"
style="
    width:100%;
    max-width:600px;
    background:#ffffff;
    border-radius:18px;
    overflow:hidden;
">

<!-- TOP BAR -->

<tr>

<td style="
    background:#2351ff;
    height:8px;
    font-size:0;
    line-height:0;
">

&nbsp;

</td>

</tr>


<!-- LOGO -->

<tr>

<td align="center"
style="
    padding:30px 30px 20px;
    background:#ffffff;
">

<img
src="$logoUrl"
alt="SideHustle"
width="180"
style="
    display:block;
    width:180px;
    max-width:80%;
    height:auto;
    border:0;
"
>

</td>

</tr>


<!-- HEADER -->

<tr>

<td style="
    padding:10px 40px 30px;
">

<div style="
    display:inline-block;
    background:#e9edff;
    color:#2351ff;
    padding:8px 13px;
    border-radius:30px;
    font-size:12px;
    font-weight:bold;
    letter-spacing:1px;
    text-transform:uppercase;
">

NEW PROJECT INQUIRY

</div>


<h1 style="
    margin:18px 0 10px;
    font-size:30px;
    line-height:1.15;
    color:#0d1220;
">

Someone wants to work with SideHustle.

</h1>


<p style="
    margin:0;
    font-size:15px;
    line-height:1.6;
    color:#61697a;
">

A new project inquiry was submitted through your website.

</p>

</td>

</tr>


<!-- CLIENT DETAILS -->

<tr>

<td style="
    padding:0 40px 25px;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
style="
    background:#f4f3ef;
    border-radius:14px;
">

<tr>

<td style="padding:20px;">

<p style="
    margin:0 0 6px;
    font-size:11px;
    font-weight:bold;
    color:#61697a;
    text-transform:uppercase;
    letter-spacing:1px;
">

Name

</p>

<p style="
    margin:0;
    font-size:17px;
    font-weight:bold;
    color:#0d1220;
">

$nameSafe

</p>

</td>

</tr>


<tr>

<td style="padding:0 20px 20px;">

<p style="
    margin:0 0 6px;
    font-size:11px;
    font-weight:bold;
    color:#61697a;
    text-transform:uppercase;
    letter-spacing:1px;
">

Email

</p>

<p style="
    margin:0;
    font-size:16px;
    color:#2351ff;
">

$emailSafe

</p>

</td>

</tr>


<tr>

<td style="padding:0 20px 20px;">

<p style="
    margin:0 0 6px;
    font-size:11px;
    font-weight:bold;
    color:#61697a;
    text-transform:uppercase;
    letter-spacing:1px;
">

Phone

</p>

<p style="
    margin:0;
    font-size:16px;
    color:#0d1220;
">

$phoneSafe

</p>

</td>

</tr>


<tr>

<td style="padding:0 20px 20px;">

<p style="
    margin:0 0 6px;
    font-size:11px;
    font-weight:bold;
    color:#61697a;
    text-transform:uppercase;
    letter-spacing:1px;
">

Service

</p>

<p style="
    margin:0;
    font-size:16px;
    font-weight:bold;
    color:#2351ff;
">

$serviceSafe

</p>

</td>

</tr>

</table>

</td>

</tr>


<!-- MESSAGE -->

<tr>

<td style="padding:0 40px 30px;">

<p style="
    margin:0 0 10px;
    font-size:11px;
    font-weight:bold;
    color:#61697a;
    text-transform:uppercase;
    letter-spacing:1px;
">

Project Message

</p>


<table width="100%" cellpadding="0" cellspacing="0" border="0"
style="
    border-left:4px solid #2351ff;
    background:#fafafa;
">

<tr>

<td style="
    padding:20px;
    font-size:15px;
    line-height:1.7;
    color:#0d1220;
">

$messageSafe

</td>

</tr>

</table>

</td>

</tr>


<!-- DATE -->

<tr>

<td style="
    padding:0 40px 30px;
">

<p style="
    margin:0;
    font-size:12px;
    color:#61697a;
">

Submitted on $date at $time

</p>

</td>

</tr>


<!-- FOOTER -->

<tr>

<td style="
    background:#0d1220;
    padding:25px 40px;
    text-align:center;
">

<p style="
    margin:0;
    color:#ffffff;
    font-size:14px;
    font-weight:bold;
">

SIDEHUSTLE

</p>

<p style="
    margin:7px 0 0;
    color:#9da4b4;
    font-size:12px;
">

Marketing • Design • Digital

</p>

</td>

</tr>

</table>

</td>

</tr>

</table>

</body>

</html>
HTML;


/* =========================================================
   HEADERS — SIDEHUSTLE
========================================================= */

$internalHeaders  = "MIME-Version: 1.0\r\n";
$internalHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$internalHeaders .= "From: SideHustle Website <{$fromEmail}>\r\n";
$internalHeaders .= "Reply-To: {$email}\r\n";


/* =========================================================
   EMAIL #2
   CONFIRMACIÓN PARA EL CLIENTE
========================================================= */

$clientSubject = "We received your SideHustle inquiry";


/* ---------- HTML CLIENTE ---------- */

$clientBody = <<<HTML
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SideHustle</title>

</head>


<body style="
    margin:0;
    padding:0;
    background:#f4f3ef;
    font-family:Arial,Helvetica,sans-serif;
    color:#0d1220;
">


<table width="100%" cellpadding="0" cellspacing="0" border="0"
style="
    background:#f4f3ef;
    padding:40px 15px;
">

<tr>

<td align="center">


<table width="600" cellpadding="0" cellspacing="0" border="0"
style="
    width:100%;
    max-width:600px;
    background:#ffffff;
    border-radius:18px;
    overflow:hidden;
">


<!-- BLUE LINE -->

<tr>

<td style="
    height:8px;
    background:#2351ff;
    font-size:0;
    line-height:0;
">

&nbsp;

</td>

</tr>


<!-- LOGO -->

<tr>

<td align="center"
style="
    padding:35px 30px 20px;
">

<img
src="$logoUrl"
alt="SideHustle"
width="190"
style="
    display:block;
    width:190px;
    max-width:80%;
    height:auto;
    border:0;
"
>

</td>

</tr>


<!-- MAIN CONTENT -->

<tr>

<td style="
    padding:10px 40px 40px;
    text-align:center;
">


<div style="
    display:inline-block;
    background:#e9edff;
    color:#2351ff;
    padding:8px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:bold;
    letter-spacing:1px;
    text-transform:uppercase;
">

MESSAGE RECEIVED

</div>


<h1 style="
    margin:20px 0 15px;
    font-size:32px;
    line-height:1.15;
    color:#0d1220;
">

Thanks, $nameSafe.

</h1>


<p style="
    margin:0 auto;
    max-width:460px;
    font-size:16px;
    line-height:1.7;
    color:#61697a;
">

We've received your project inquiry and our team will review the information you sent us.

</p>

</td>

</tr>


<!-- SERVICE CARD -->

<tr>

<td style="
    padding:0 40px 30px;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
style="
    background:#f4f3ef;
    border-radius:15px;
">

<tr>

<td style="
    padding:25px;
    text-align:center;
">

<p style="
    margin:0 0 8px;
    color:#61697a;
    font-size:11px;
    font-weight:bold;
    letter-spacing:1px;
    text-transform:uppercase;
">

YOUR REQUEST

</p>


<p style="
    margin:0;
    color:#2351ff;
    font-size:20px;
    font-weight:bold;
">

$serviceSafe

</p>

</td>

</tr>

</table>

</td>

</tr>


<!-- MESSAGE -->

<tr>

<td style="
    padding:0 40px 30px;
">

<p style="
    margin:0 0 12px;
    color:#61697a;
    font-size:12px;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:1px;
">

WHAT HAPPENS NEXT?

</p>


<p style="
    margin:0;
    color:#0d1220;
    font-size:15px;
    line-height:1.7;
">

We'll take a look at your project details and get back to you using the contact information you provided.

</p>

</td>

</tr>


<!-- CTA -->

<tr>

<td align="center"
style="
    padding:0 40px 40px;
">

<a
href="$siteUrl"
style="
    display:inline-block;
    background:#2351ff;
    color:#ffffff;
    text-decoration:none;
    padding:15px 25px;
    border-radius:10px;
    font-size:14px;
    font-weight:bold;
">

Visit SideHustle ↗

</a>

</td>

</tr>


<!-- FOOTER -->

<tr>

<td style="
    background:#0d1220;
    padding:30px 40px;
    text-align:center;
">


<p style="
    margin:0;
    color:#ffffff;
    font-size:16px;
    font-weight:bold;
">

SIDEHUSTLE

</p>


<p style="
    margin:8px 0 0;
    color:#9da4b4;
    font-size:12px;
    line-height:1.5;
">

Marketing • Design • Digital

</p>


<p style="
    margin:15px 0 0;
    color:#6f7789;
    font-size:11px;
">

This is an automated confirmation email.

</p>

</td>

</tr>


</table>

</td>

</tr>

</table>


</body>

</html>
HTML;


/* =========================================================
   HEADERS — CLIENTE
========================================================= */

$clientHeaders  = "MIME-Version: 1.0\r\n";
$clientHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$clientHeaders .= "From: SideHustle <{$fromEmail}>\r\n";
$clientHeaders .= "Reply-To: {$sidehustleEmail}\r\n";


/* =========================================================
   ENVIAR LOS DOS CORREOS
========================================================= */

$internalSent = mail(
    $sidehustleEmail,
    $internalSubject,
    $internalBody,
    $internalHeaders
);


$clientSent = mail(
    $email,
    $clientSubject,
    $clientBody,
    $clientHeaders
);


/* =========================================================
   RESULTADO
========================================================= */

if ($internalSent && $clientSent) {

    header("Location: contact.html?success=1");
    exit;

}


/* Si SideHustle recibió la solicitud aunque la
   confirmación del cliente fallara, mostramos éxito. */

if ($internalSent) {

    header("Location: contact.html?success=1");
    exit;

}


/* Error */

header("Location: contact.html?error=3");
exit;

?>