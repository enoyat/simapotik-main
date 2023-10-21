Imports System.Data.Odbc
Imports System.Net
Imports System.Text
Imports MySql.Data.MySqlClient



Public Class FormLogin

    Sub Ceklogin()
        Try
            Dim url = urlprefix + "login"
            Dim client = New WebClient()
            Dim method = "POST"
            Dim parameters = New Specialized.NameValueCollection

            parameters.Add("email", TextBox1.Text)
            parameters.Add("password", TextBox2.Text)
            parameters.Add("token", TextBox3.Text)

            ' Always returns a byte[] array data as a response. */
            Dim response_data = client.UploadValues(url, method, parameters)

            ' Parse the returned data (if any) if needed.
            Dim responseString = UnicodeEncoding.UTF8.GetString(response_data)
            Dim jsonObject As Newtonsoft.Json.Linq.JObject = Newtonsoft.Json.Linq.JObject.Parse(responseString)
            ' Dim jsonArray As JArray = jsonObject("result")
            Dim islogin = jsonObject.SelectToken("status").ToString

            If islogin = "success" Then
                For Each Row2 In jsonObject("data").ToList()
                    username = Row2("email").ToString
                    kdpst = Row2("kdpst").ToString
                    toko = Row2("toko").ToString
                    alamat = Row2("alamat").ToString
                    telpon = Row2("telpon").ToString
                    nim = Row2("nim").ToString
                Next
                MsgBox("Selamat Datang!! " + username, vbInformation)
                FormUtama.Statusmenu(True)
                FormUtama.LoginToolStripMenuItem.Enabled = False

                Close()
            Else
                MsgBox("Login Gagal.. anda tidak berhak masuk!!", vbInformation)
            End If
        Catch ex As Exception
            MsgBox(ex.ToString)
        End Try

    End Sub
    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Close()
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Ceklogin()
    End Sub

    Private Sub FormLogin_Load(sender As Object, e As EventArgs) Handles MyBase.Load

    End Sub
End Class