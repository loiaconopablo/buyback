@ECHO OFF

@SETLOCAL

CALL generate-tables-migrations %*
CALL generate-data-migrations %*

@ENDLOCAL

@ECHO.
@PAUSE