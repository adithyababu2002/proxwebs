$logFile = Join-Path $PSScriptRoot '..\storage\logs\laravel.log'

if (-not (Test-Path $logFile)) {
    New-Item -ItemType File -Path $logFile -Force | Out-Null
}

Get-Content $logFile -Wait -Tail 20
