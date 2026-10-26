Set WshShell = CreateObject("WScript.Shell")
' Hide the console (0) and start the launcher
' Start the launcher in hidden mode (0)
WshShell.Run "cmd /c LaunchAlifPharma.bat", 0, False
Set WshShell = Nothing
