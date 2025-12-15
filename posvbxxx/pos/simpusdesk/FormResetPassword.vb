Imports MySql.Data.MySqlClient
Imports System
Imports System.Net
Public Class FormResetPassword

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Try
            Dim parameters = New Specialized.NameValueCollection
            parameters.Add("pwd", TextBox1.Text)
            parameters.Add("userid", TextBox2.Text)
            Dim respons = postData(urlprefix + "petugas/resetpassword", "POST", parameters)
            Dim state = respons.SelectToken("success").ToString
            If state = True Then
                MsgBox("Simpan sukses!!", vbInformation)
            Else
                MsgBox("ada kesahalan data")
            End If
            Me.Close()

        Catch ex As Exception
            MsgBox(ex.ToString)
        End Try
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Close()
    End Sub
End Class