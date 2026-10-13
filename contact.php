<?php

// ======================================================
// SIDEHUSTLE — CONTACT FORM
// ======================================================

// ------------------------------------------------------
// CONFIGURACIÓN
// ------------------------------------------------------

// CORREO PRINCIPAL QUE RECIBIRÁ LAS SOLICITUDES (Tú)
$sidehustleEmail = "sidehustleadma@gmail.com";

// CORREO SECUNDARIO (Copia oculta - Bcc)
$copiaEmail = "xavierhdzmtr@gmail.com";

// CORREO REAL DE ENVÍO EN HOSTINGER (Remitente oficial)
$fromEmail = "info@sidehustleandflow.com";

// URL DEL SITIO Y LOGO
$siteUrl = "https://sidehustleandflow.com";
$logoUrl = "https://sidehustleandflow.com/assets/img/logo2.png"; // Asegúrate de que esta ruta sea correcta

// ------------------------------------------------------
// VERIFICAR MÉTODO
// ------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Location: contact.html");
    exit;
}

// ------------------------------------------------------
// RECIBIR DATOS
// ------------------------------------------------------

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");

// ------------------------------------------------------
// VALIDACIONES
// ------------------------------------------------------

if ($name === "" || $email === "" || $service === "" || $message === "") {
    http_response_code(400);
    header("Location: contact.html?error=1");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    header("Location: contact.html?error=2");
    exit;
}

// ------------------------------------------------------
// SEGURIDAD PARA HTML
// ------------------------------------------------------

$nameSafe = htmlspecialchars($name, ENT_QUOTES, "UTF-8");
$emailSafe = htmlspecialchars($email, ENT_QUOTES, "UTF-8");
$phoneSafe = htmlspecialchars($phone !== "" ? $phone : "Not provided", ENT_QUOTES, "UTF-8");
$serviceSafe = htmlspecialchars($service, ENT_QUOTES, "UTF-8");
$messageSafe = nl2br(htmlspecialchars($message, ENT_QUOTES, "UTF-8"));

$date = date("F j, Y");
$time = date("g:i A");

// ======================================================
// 1. CORREO DE NOTIFICACIÓN INTERNA PARA SIDEHUSTLE
// ======================================================

$internalSubject = "New SideHustle Project Inquiry — " . $service;

$internalBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New SideHustle Inquiry</title>
</head>
<body style="margin:0; padding:0; background:#0d1220; font-family:Arial,Helvetica,sans-serif; color:#ffffff;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0d1220; padding:40px 15px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px; background:#1e293b; border-radius:18px; overflow:hidden;">

<!-- TOP BAR -->
<tr><td style="background:#2351ff; height:6px; font-size:0; line-height:0;">&nbsp;</td></tr>

<!-- LOGO -->
<tr>
<td align="center" style="padding:30px 30px 20px; background:#1e293b;">
<img src="$logoUrl" alt="SideHustle" width="180" style="display:block; width:180px; max-width:80%; height:auto; border:0;">
</td>
</tr>

<!-- HEADER -->
<tr>
<td style="padding:10px 40px 30px; text-align:center;">
<div style="display:inline-block; background:#2351ff; color:#ffffff; padding:6px 14px; border-radius:30px; font-size:11px; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">
NEW PROJECT INQUIRY
</div>
<h1 style="margin:20px 0 10px; font-size:28px; line-height:1.2; color:#ffffff;">Someone wants to work with SideHustle.</h1>
<p style="margin:0; font-size:15px; color:#9da4b4;">Submitted on $date at $time</p>
</td>
</tr>

<!-- CLIENT DETAILS -->
<tr>
<td style="padding:0 40px 30px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0f172a; border-radius:14px; padding:25px;">
<tr>
<td style="padding-bottom:20px;">
<p style="margin:0 0 6px; font-size:11px; font-weight:bold; color:#64748b; text-transform:uppercase; letter-spacing:1px;">Name</p>
<p style="margin:0; font-size:17px; font-weight:bold; color:#ffffff;">$nameSafe</p>
</td>
</tr>
<tr>
<td style="padding-bottom:20px;">
<p style="margin:0 0 6px; font-size:11px; font-weight:bold; color:#64748b; text-transform:uppercase; letter-spacing:1px;">Email</p>
<p style="margin:0; font-size:16px; color:#38bdf8;">
<a href="mailto:$emailSafe" style="color:#38bdf8; text-decoration:none;">$emailSafe</a>
</p>
</td>
</tr>
<tr>
<td style="padding-bottom:20px;">
<p style="margin:0 0 6px; font-size:11px; font-weight:bold; color:#64748b; text-transform:uppercase; letter-spacing:1px;">Phone</p>
<p style="margin:0; font-size:16px; color:#ffffff;">$phoneSafe</p>
</td>
</tr>
<tr>
<td>
<p style="margin:0 0 6px; font-size:11px; font-weight:bold; color:#64748b; text-transform:uppercase; letter-spacing:1px;">Service Requested</p>
<p style="margin:0; font-size:16px; font-weight:bold; color:#38bdf8;">$serviceSafe</p>
</td>
</tr>
</table>
</td>
</tr>

<!-- MESSAGE -->
<tr>
<td style="padding:0 40px 40px;">
<p style="margin:0 0 10px; font-size:11px; font-weight:bold; color:#64748b; text-transform:uppercase; letter-spacing:1px;">Project Details</p>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-left:3px solid #2351ff; background:#0f172a;">
<tr>
<td style="padding:20px; font-size:15px; line-height:1.7; color:#cbd5e1;">$messageSafe</td>
</tr>
</table>
</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="background:#0a0f18; padding:25px 40px; text-align:center;">
<p style="margin:0; color:#ffffff; font-size:14px; font-weight:bold;">SIDEHUSTLE</p>
<p style="margin:7px 0 0; color:#64748b; font-size:12px;">Marketing • Design • Digital</p>
</td>
</tr>

</table>
</td>
</tr>
</table>

</body>
</html>
HTML;

$internalHeaders  = "MIME-Version: 1.0\r\n";
$internalHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$internalHeaders .= "From: SideHustle Website <{$fromEmail}>\r\n";
$internalHeaders .= "Reply-To: {$email}\r\n";
// AQUÍ SE AGREGA LA COPIA OCULTA (Bcc)
$internalHeaders .= "Bcc: {$copiaEmail}\r\n";

// ======================================================
// 2. CORREO DE CONFIRMACIÓN PARA EL CLIENTE
// ======================================================

$clientSubject = "We received your SideHustle inquiry";

$clientBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SideHustle Message Received</title>
</head>

<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial,Helvetica,sans-serif; color:#0f172a;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f1f5f9; padding:40px 15px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px; background:#ffffff; border-radius:18px; overflow:hidden;">

<!-- BLUE LINE -->
<tr><td style="height:6px; background:#2351ff; font-size:0; line-height:0;">&nbsp;</td></tr>

<!-- LOGO -->
<tr>
<td align="center" style="padding:40px 30px 20px;">
<img src="$logoUrl" alt="SideHustle" width="180" style="display:block; width:180px; max-width:80%; height:auto; border:0;">
</td>
</tr>

<!-- MAIN CONTENT -->
<tr>
<td style="padding:10px 40px 30px; text-align:center;">
<div style="display:inline-block; background:#e0e7ff; color:#2351ff; padding:6px 14px; border-radius:30px; font-size:11px; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">
MESSAGE RECEIVED
</div>
<h1 style="margin:20px 0 15px; font-size:32px; line-height:1.2; color:#0f172a;">Thanks, $nameSafe.</h1>
<p style="margin:0 auto; max-width:460px; font-size:16px; line-height:1.7; color:#475569;">
We've received your inquiry and our team will review the information you sent us.
</p>
</td>
</tr>

<!-- SERVICE CARD -->
<tr>
<td style="padding:0 40px 30px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:15px;">
<tr>
<td style="padding:25px; text-align:center;">
<p style="margin:0 0 8px; color:#64748b; font-size:11px; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">YOUR REQUEST</p>
<p style="margin:0; color:#2351ff; font-size:20px; font-weight:bold;">$serviceSafe</p>
</td>
</tr>
</table>
</td>
</tr>

<!-- NEXT STEPS -->
<tr>
<td style="padding:0 40px 30px;">
<p style="margin:0 0 10px; color:#64748b; font-size:11px; font-weight:bold; text-transform:uppercase; letter-spacing:1px;">WHAT HAPPENS NEXT?</p>
<p style="margin:0; color:#334155; font-size:15px; line-height:1.7;">
We'll take a look at your project details and get back to you using the contact information you provided.
</p>
</td>
</tr>

<!-- CTA -->
<tr>
<td align="center" style="padding:0 40px 40px;">
<a href="$siteUrl" style="display:inline-block; background:#2351ff; color:#ffffff; text-decoration:none; padding:15px 30px; border-radius:30px; font-size:14px; font-weight:bold; letter-spacing:0.5px;">
Visit SideHustle &nbsp;→
</a>
</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="background:#0f172a; padding:30px 40px; text-align:center;">
<p style="margin:0; color:#ffffff; font-size:16px; font-weight:bold;">SIDEHUSTLE</p>
<p style="margin:8px 0 0; color:#94a3b8; font-size:12px; line-height:1.5;">Marketing • Design • Digital</p>
<p style="margin:15px 0 0; color:#475569; font-size:11px;">This is an automated confirmation email.</p>
</td>
</tr>

</table>
</td>
</tr>
</table>

</body>
</html>
HTML;

$clientHeaders  = "MIME-Version: 1.0\r\n";
$clientHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$clientHeaders .= "From: SideHustle <{$fromEmail}>\r\n";
$clientHeaders .= "Reply-To: {$fromEmail}\r\n";

// ======================================================
// ENVIAR LOS CORREOS
// ======================================================

$internalSent = mail($sidehustleEmail, $internalSubject, $internalBody, $internalHeaders);
$clientSent = mail($email, $clientSubject, $clientBody, $clientHeaders);

// ======================================================
// RESULTADO Y REDIRECCIÓN
// ======================================================

if ($internalSent) {
    header("Location: contact.html?success=1");
    exit;
} else {
    http_response_code(500);
    header("Location: contact.html?error=3");
    exit;
}

?>