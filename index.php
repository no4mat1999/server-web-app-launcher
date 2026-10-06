<?php
$serverName = "SERVER NAME HERE";

$currentHost = $_SERVER['HTTP_HOST'];
if (strpos($currentHost, ':') !== false) {
    $currentHost = explode(':', $currentHost)[0];
}


$jsonFile = 'services.json';
$services = [];

if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $services = json_decode($jsonData, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($serverName); ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="main-card">
        <div class="card-left">
            <img src="img.jpg" alt="Banner" class="banner-img">
        </div>


        <div class="card-right">
            <h1 class="server-title"><?php echo htmlspecialchars($serverName); ?></h1>
            
            <div class="service-list-container" id="serviceList">
                <ul class="service-list">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <?php 
                                $protocol = strtolower($service['protocol'] ?? 'http');
                                $port = $service['port'] ?? '80';
                                
                                $targetHost = (!empty($service['ip'])) ? $service['ip'] : $currentHost;
                                

                                $pagePath = '';
                                if (!empty($service['page'])) {
                                    $pagePath = '/' . ltrim($service['page'], '/');
                                }

                                $serviceUrl = "{$protocol}://{$targetHost}:{$port}{$pagePath}";
                            ?>
                            <li class="service-item">
                                <a href="<?php echo htmlspecialchars($serviceUrl); ?>" target="_blank" class="service-link">
                                    <div class="service-header">
                                        <span class="service-name"><?php echo htmlspecialchars($service['name']); ?></span>
                                        <span class="service-port">:<?php echo htmlspecialchars($port); ?></span>
                                    </div>
                                    <div class="service-desc">
                                        <?php echo htmlspecialchars($service['description']); ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="service-item">
                            <div class="service-desc">No services found in configuration file.</div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
