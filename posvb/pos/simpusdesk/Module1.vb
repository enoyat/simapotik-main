Imports System.IO
Imports System.Net
Imports System.Text
Imports MySql.Data.MySqlClient
Imports Newtonsoft.Json.Linq

Module modConnection
    Public urlprefix As String
    Public username, kdpst As String
    Public toko = "APOTEK SEHATIJAYA JUWANA"
    Public alamat = "Jl.P.Diponegoro no 38"
    Public telpon = "Telp. WA: 0853-8590-1298"
    Public npwp = "NPWP: 02.908.598.2-507.000"

    Public nim = ""

    Public ipserver, idkoneksi As String
    Public role_id As String
    Public id_petugas As String
    Public rowindex As Integer
    Public biayadenda As Double = 500
    Public simpan, ubah, hapus As String
    Public str As String
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
        urlprefix = BacaBarisKe(Application.StartupPath & "\config.txt", 1)
    End Sub

End Module