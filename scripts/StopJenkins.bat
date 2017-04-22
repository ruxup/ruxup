net stop | find "Jenkins" > nul 2>&1 
if not .%errorlevel%.==.0. goto stopservice 
goto skip


:stopservice 
net stop "Jenkins" 
echo service stops @ %date% %time% >> C:\checklog.txt 

:skip
pause 