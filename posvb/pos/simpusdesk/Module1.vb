Imports System.IO
Imports System.Net
Imports System.Text
Imports MySql.Data.MySqlClient
Imports Newtonsoft.Json.Linq

Module modConnection
    'Public urlprefix = "http://192.168.100.104:8000/api/"
    Public urlprefix = "http://192.168.20.252/api/"
    Public username, kdpst, toko, alamat, telpon, nim As String

    Public ipserver, idkoneksi As String
    Public role_id As String
    Public id_petugas As String
    Public rowindex As Integer
    Public biayadenda As Double = 500
    Public simpan, ubah, hapus As String
    Public str As String
    Public strServer As String = "localhost"
    Public strDbase As String = "simpus" 'Databas name
    Public strUser As String = "root"  'Database user
    Public strPass As String = ""     'Database password
    Public connDB As MySqlConnection

    Public Function postData(url As String, method As String, parameters As Specialized.NameValueCollection)
        Dim client = New WebClient()

        Dim response_data = client.UploadValues(url, method, parameters)
        Dim responseString = UnicodeEncoding.UTF8.GetString(response_data)
        Dim jsonObject As Newtonsoft.Json.Linq.JObject = Newtonsoft.Json.Linq.JObject.Parse(responseString)
        Return jsonObject
    End Function
    Public Function getData(url) As Newtonsoft.Json.Linq.JObject
        Dim webClient As New System.Net.WebClient
        Dim result As String = webClient.DownloadString(url)
        Dim jsonObject As Newtonsoft.Json.Linq.JObject = Newtonsoft.Json.Linq.JObject.Parse(result)
        Return jsonObject
    End Function



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
    Sub Konfigurasi()
        ipserver = BacaBarisKe(Application.StartupPath & "\config.txt", 1)
        idkoneksi = ";user id=admin_simpus;database=admin_simpus;password=//Dadiati**/simpus;persistsecurityinfo=True"
    End Sub
    Sub Koneksi()
        Dim Lokasidata As String
        Lokasidata = My.Settings.simpusConnectionString
        'Lokasidata = "server = 192.168.100.212;user id=admin_simpus;password=//Dadiati**/simpus;persistsecurityinfo=True;database=admin_simpus"
        connDB = New MySql.Data.MySqlClient.MySqlConnection(Lokasidata)
        If connDB.State = ConnectionState.Open Then
            connDB.Close()
        Else
            connDB = New MySql.Data.MySqlClient.MySqlConnection(Lokasidata)
            connDB.Open()
        End If
    End Sub

End Module