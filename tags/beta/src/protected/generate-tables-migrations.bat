@ECHO OFF

@SETLOCAL

CALL yiic deftmigrations TableSchema --name=create --interactive=0 %*

@ENDLOCAL

@ECHO.
@PAUSE