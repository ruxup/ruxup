net start | find "Jenkins" > nul 2>&1 
if not .%errorlevel%.==.0. goto startservice 
goto skip


:startservice 
net start "Jenkins" 
echo service starts @ %date% %time% >> C:\checklog.txt 

:skip
pause 