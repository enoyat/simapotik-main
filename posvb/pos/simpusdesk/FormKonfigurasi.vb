Imports System.IO
Imports System.Net
Imports System.Text
Imports MySql.Data.MySqlClient
Public Class FormKonfigurasi


    Public Function BacaBarisKe(ByVal FullPath As String, ByVal baris As Integer)
        Dim fileReader As StreamReader
        Dim content As String = ""
        Dim i As Integer
        Try
            fileReader = New StreamReader(FullPath)
            For i = 1 To baris
                content = fileReader.ReadLine()
            Next
            fileReader.Close()
        Catch x As Exception
            MsgBox(x.Message)
        End Try
        Return content
    End Function
    Function simpan()
        Dim path As String = Application.StartupPath & "\config.txt"
        Dim teks As String = txtip.Text

        File.WriteAllText(path, teks)
        MsgBox("Sukses")
        Close()
    End Function
    Private Sub FormKonfigurasi_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtip.Text = BacaBarisKe(Application.StartupPath & "\config.txt", 1)
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Close()
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        simpan()
    End Sub
End Class