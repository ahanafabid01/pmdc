$files = Get-ChildItem -Path "c:\xampp\htdocs\pmdc\pages\portal\admin", "c:\xampp\htdocs\pmdc\pages\portal\teacher" -Filter *.php
foreach ($f in $files) {
    if ($f.Name -ne 'api-students.php') {
        $content = Get-Content $f.FullName -Raw
        if ($content -notmatch 'session_check\.php') {
            $newContent = "<?php require_once '../../../includes/session_check.php'; ?>" + "`r`n" + $content
            Set-Content -Path $f.FullName -Value $newContent
        }
    }
}
Write-Output "Session check prepended to portal pages."
