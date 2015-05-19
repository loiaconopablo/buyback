@ECHO OFF

@SETLOCAL

CALL yiic deftmigrations TableData --name=data --interactive=0 %*

@ENDLOCAL

@ECHO.
@PAUSE