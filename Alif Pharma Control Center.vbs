Set WshShell = CreateObject("WScript.Shell")
Set fso = CreateObject("Scripting.FileSystemObject")

' Get the absolute path of the folder where THIS script is located
scriptDir = fso.GetParentFolderName(WScript.ScriptFullName)

' The bundled Electron executable that includes its own Node runtime
electronExe = scriptDir & "\node_modules\electron\dist\electron.exe"

If fso.FileExists(electronExe) Then
    ' Change directory to the app root to ensure relative paths in JS work correctly
    WshShell.CurrentDirectory = scriptDir
    
    ' Run silently (0) and pass the control center script as an argument
    ' Added extra quotes to handle potential spaces in path
    WshShell.Run """" & electronExe & """ ""control_center.cjs""", 0, False
Else
    MsgBox "Electron binary not found!" & vbCrLf & "Please ensure you are in the project root." & vbCrLf & vbCrLf & "Expected: " & electronExe, 16, "Alif Pharma"
End If

Set WshShell = Nothing
Set fso = Nothing
