@echo off
setlocal


set CONTAINER_NAME=fantomls
set IMAGE_NAME=deploy-license

REM Going to the right folder
cd /d "%cd%"
echo "%cd%"

REM Checking if the container exists
docker ps -a | findstr /C:"%CONTAINER_NAME%" > nul
if %errorlevel% equ 0 (
    echo The container is already exist.
    REM Checking argument -forcebuild
    if "%1"=="forcebuild" (
        echo Forcely build the container...
        docker compose build %IMAGE_NAME% --no-cache
        docker compose build db --no-cache
    ) else (
        echo Skip building. Updating files

        docker compose cp "%cd%/" %IMAGE_NAME%:/app/
    )
    docker compose up %IMAGE_NAME% -d
) else (
    echo The container wasn't found. Building...
    docker compose build %IMAGE_NAME%
    docker compose up %IMAGE_NAME% -d
)

endlocal
