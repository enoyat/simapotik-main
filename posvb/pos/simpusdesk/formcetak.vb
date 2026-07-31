Imports Microsoft.Reporting.WinForms
Imports System.Drawing.Printing
Imports Newtonsoft.Json
Imports System.Net.Http
Imports System.Text

Public Class formcetak
    Dim WithEvents PD As New PrintDocument
    Dim PPD As New PrintPreviewDialog
    Dim jmltotal As Integer
    Dim grandtotal As Integer

    Dim jmldiskon As Integer

    Dim panjang As Integer
    Dim noinvoice, kasir, tgltrans, jam As String
    Sub cari()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("id", txtcari.Text)

        Dim respons = postData(urlprefix + "transaksi/getinvoice", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("id", GetType(String))
            data.Columns.Add("idcustomer", GetType(String))
            data.Columns.Add("tgltrans", GetType(String))
            data.Columns.Add("total", GetType(String))
            data.Columns.Add("tipepenjualan", GetType(String))
            data.Columns.Add("email", GetType(String))
            data.Columns.Add("jam", GetType(String))



            For Each Row2 In respons("data")
                data.Rows.Add(Row2("id").ToString(),
                          Row2("idcustomer").ToString(),
                          Row2("tgltrans").ToString(),
                           Row2("total").ToString(),
                            Row2("tipepenjualan").ToString(),
                            Row2("email").ToString(),
                            Row2("jam").ToString())
            Next
            DataGridView1.DataSource = data
            DataGridView1.Columns(1).Width = 300
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub
    Sub caridetail()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("id", txtcari.Text)

        Dim respons = postData(urlprefix + "transaksi/detailinvoice", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable


            data.Columns.Add("kdbarang", GetType(String))
            data.Columns.Add("namabarang", GetType(String))
            data.Columns.Add("harga", GetType(String))
            data.Columns.Add("qty", GetType(String))
            data.Columns.Add("jml", GetType(String))
            data.Columns.Add("diskonpersen", GetType(String))
            data.Columns.Add("diskon", GetType(String))
            data.Columns.Add("jumlah", GetType(String))
            data.Columns.Add("golongan", GetType(String))


            For Each Row2 In respons("data")

                Dim jml = Int(Row2("harga")) * Int(Row2("qty"))

                data.Rows.Add(Row2("kdbarang").ToString(),
                          Row2("namabarang").ToString(),
                          Row2("harga").ToString(),
                           Row2("qty").ToString(),
                           jml,
                            Row2("diskonpersen").ToString(),
                            Row2("diskon").ToString,
                            Row2("jumlah").ToString(),
                            Row2("idgolongan").ToString())

            Next
            DataGridView2.DataSource = data
            DataGridView2.Columns(1).Width = 300
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub

    Private Sub formcetak_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtcari.Text = "DR"
        Call cari()
        txtcari.Text = ""
        txtcari.Select()
    End Sub

    Private Sub txtcari_KeyDown(sender As Object, e As KeyEventArgs) Handles txtcari.KeyDown
        If (e.KeyCode = Keys.Enter) Then

            If (Len(txtcari.Text) > 0) Then
                Call cari()
            End If
        End If
    End Sub
    Private Sub DataGridView1_KeyDown(sender As Object, e As KeyEventArgs) Handles DataGridView1.KeyDown

        If (e.KeyCode = Keys.Enter) Then
            FormPenjualanResep.txtiddokter.Text = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
            FormPenjualanResep.txtnamadokter.Text = Convert.ToString(DataGridView1.Item(1, DataGridView1.CurrentRow.Index).Value)
            Close()
        End If
    End Sub

    Private Sub btnsimpan_Click(sender As Object, e As EventArgs) Handles btnsimpan.Click
        Dim status = Convert.ToString(DataGridView1.Item(4, DataGridView1.CurrentRow.Index).Value)
        If (status = "K") Then
            MsgBox("Status masih belum Tunai")
        Else
            ubahpanjang()
            hitung()
            PPD.Document = PD
            'PPD.ShowDialog()
            PD.Print()
        End If

    End Sub

    Private Sub PrintDocument1_PrintPage(sender As Object, e As PrintPageEventArgs) Handles PrintDocument1.PrintPage

    End Sub
    Sub hitung()
        Try
            jmltotal = 0
            jmldiskon = 0
            Dim jmldata As Integer
            jmldata = DataGridView2.Rows.Count

            For i = 0 To jmldata - 1
                jmldiskon += Int(DataGridView2.Item(6, i).Value)
                jmltotal += Int(DataGridView2.Item(7, i).Value)

            Next
            grandtotal = jmldiskon + jmltotal


        Catch ex As Exception

        End Try
    End Sub
    Sub ubahpanjang()

        Dim rowcount As Integer
        panjang = 0
        rowcount = DataGridView2.Rows.Count
        panjang = rowcount * 15
        panjang = panjang + 300
    End Sub
    Private Sub PD_PrintPage(sender As Object, e As PrintPageEventArgs) Handles PD.PrintPage
        Dim namaprinter = cekprinter()
        Dim f10 As New Font("Times New Roman", 8, FontStyle.Regular)
        Dim f6 As New Font("Times New Roman", 6, FontStyle.Regular)
        Dim f10b As New Font("Times New Roman", 8, FontStyle.Bold)
        Dim f14 As New Font("Times New Roman", 12, FontStyle.Bold)
        Dim leftmargin As Integer = PD.DefaultPageSettings.Margins.Left
        Dim centermargin As Integer = PD.DefaultPageSettings.PaperSize.Width / 2
        Dim rigtmargin As Integer = PD.DefaultPageSettings.PaperSize.Width
        Dim garis = "----------------------------------------------------------------------------"

        If (namaprinter = "EPSON TM-U220 Receipt") Then
            f10 = New Font("FontB11", 6, FontStyle.Regular)
            f6 = New Font("FontB11", 6, FontStyle.Regular)
            f10b = New Font("FontB11", 7, FontStyle.Bold)
            f14 = New Font("Times New Roman", 14, FontStyle.Bold)
            leftmargin = PD.DefaultPageSettings.Margins.Left
            centermargin = PD.DefaultPageSettings.PaperSize.Width / 2
            rigtmargin = PD.DefaultPageSettings.PaperSize.Width
            garis = "--------------------------------------------------------------------------------------------------------"

        End If



        Dim kanan As New StringFormat
        Dim tengah As New StringFormat
        kanan.Alignment = StringAlignment.Far
        tengah.Alignment = StringAlignment.Center
        Dim hargagolongan = 0

        e.Graphics.DrawString(toko, f14, Brushes.Black, centermargin, 5, tengah)
        e.Graphics.DrawString(alamat, f10, Brushes.Black, centermargin, 25, tengah)
        e.Graphics.DrawString(telpon, f10, Brushes.Black, centermargin, 40, tengah)

        e.Graphics.DrawString("NOTA APOTEK", f10, Brushes.Black, 0, 60)
        e.Graphics.DrawString(tgltrans, f10, Brushes.Black, 0, 75)
        e.Graphics.DrawString(npwp, f10, Brushes.Black, 0, 90)
        e.Graphics.DrawString("Harga sudah termasuk PPN", f10, Brushes.Black, 0, 105)
        e.Graphics.DrawString("No. Nota", f10, Brushes.Black, 0, 125)
        e.Graphics.DrawString(":", f10, Brushes.Black, 65, 125)
        e.Graphics.DrawString(noinvoice, f10, Brushes.Black, 68, 125)
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, 135)
        e.Graphics.DrawString("Qty", f10, Brushes.Black, 0, 150)
        e.Graphics.DrawString("Nama", f10, Brushes.Black, 25, 150)
        e.Graphics.DrawString("Harga", f10, Brushes.Black, 180, 150)
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, 165)
        Dim jmldata As Integer
        jmldata = DataGridView2.Rows.Count
        Dim tinggi As Integer
        Dim i As Long

        For baris As Integer = 0 To jmldata - 1
            If (DataGridView2.Rows(baris).Cells(8).Value.ToString = "G0001" Or DataGridView2.Rows(baris).Cells(8).Value.ToString = "G0004") Or DataGridView2.Rows(baris).Cells(8).Value.ToString = "G0006" Then
                hargagolongan = hargagolongan + (DataGridView2.Rows(baris).Cells(7).Value)
            Else
                tinggi += 15
                e.Graphics.DrawString(DataGridView2.Rows(baris).Cells(3).Value.ToString, f10, Brushes.Black, 0, 165 + tinggi)
                Dim jmlnamabarang = Len(DataGridView2.Rows(baris).Cells(1).Value.ToString)
                If jmlnamabarang > 30 Then
                    Dim namabarangpendek = DataGridView2.Rows(baris).Cells(1).Value.ToString

                    e.Graphics.DrawString(namabarangpendek.Substring(0, Math.Min(30, namabarangpendek.Length)), f10, Brushes.Black, 25, 165 + tinggi)
                Else
                    e.Graphics.DrawString(DataGridView2.Rows(baris).Cells(1).Value.ToString, f10, Brushes.Black, 25, 165 + tinggi)
                End If
                i = DataGridView2.Rows(baris).Cells(4).Value
                DataGridView2.Rows(baris).Cells(4).Value = Format(i, "##,##0")
                e.Graphics.DrawString(DataGridView2.Rows(baris).Cells(4).Value.ToString, f10, Brushes.Black, rigtmargin, 165 + tinggi, kanan)
            End If
        Next
        If (hargagolongan > 0) Then
            tinggi += 15
            e.Graphics.DrawString("1", f10, Brushes.Black, 0, 165 + tinggi)
            e.Graphics.DrawString("Obat-Obatan", f10, Brushes.Black, 25, 165 + tinggi)
            e.Graphics.DrawString(Format(grandtotal, "##,##0"), f10, Brushes.Black, rigtmargin, 165 + tinggi, kanan)
        End If
        tinggi = 180 + tinggi
        Dim bayar = 0
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, tinggi)
        e.Graphics.DrawString(kasir, f6, Brushes.Black, 0, 10 + tinggi)
        e.Graphics.DrawString("Total : ", f10b, Brushes.Black, 120, 10 + tinggi)
        e.Graphics.DrawString(Format(grandtotal, "##,##0"), f10b, Brushes.Black, rigtmargin, 10 + tinggi, kanan)
        e.Graphics.DrawString("Diskon: ", f10b, Brushes.Black, 120, 20 + tinggi)
        e.Graphics.DrawString(Format(jmldiskon, "##,##0"), f10b, Brushes.Black, rigtmargin, 20 + tinggi, kanan)
        e.Graphics.DrawString("Jumlah : ", f10b, Brushes.Black, 120, 30 + tinggi)
        e.Graphics.DrawString(Format(jmltotal, "##,##0"), f10b, Brushes.Black, rigtmargin, 30 + tinggi, kanan)
        e.Graphics.DrawString("Mohon periksa kembalian dan barang yang telah", f10, Brushes.Black, 0, 60 + tinggi)
        e.Graphics.DrawString("dibeli tidak bisa dikembalikan", f10, Brushes.Black, 0, 70 + tinggi)
        e.Graphics.DrawString("SEMOGA LEKAS SEMBUH", f10, Brushes.Black, 0, 80 + tinggi)
        e.Graphics.DrawString("~ 0 ~", f10, Brushes.Black, centermargin, 100 + tinggi)
    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick
        noinvoice = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
        kasir = Convert.ToString(DataGridView1.Item(5, DataGridView1.CurrentRow.Index).Value)
        jam = Convert.ToString(DataGridView1.Item(6, DataGridView1.CurrentRow.Index).Value)
        tgltrans = Convert.ToString(DataGridView1.Item(2, DataGridView1.CurrentRow.Index).Value)
        jmltotal = Convert.ToString(DataGridView1.Item(3, DataGridView1.CurrentRow.Index).Value)

        Call caridetail()

    End Sub

    Private Sub txtcari_TextChanged(sender As Object, e As EventArgs) Handles txtcari.TextChanged

    End Sub

    Private Sub PD_BeginPrint(sender As Object, e As PrintEventArgs) Handles PD.BeginPrint
        Dim pagesetup As New PageSettings
        Dim namaprinter = cekprinter()
        If (namaprinter = "EPSON TM-U220 Receipt") Then
            pagesetup.PaperSize = New PaperSize("Custom", 240, panjang)
        Else
            pagesetup.PaperSize = New PaperSize("Custom", 280, panjang)
        End If
        PD.DefaultPageSettings = pagesetup
    End Sub
    Function SendJsonToApi(apiUrl As String, jsonData As String, ByRef responseContent As String) As Boolean
        Try
            Using client As New HttpClient()
                Dim content As New StringContent(jsonData, Encoding.UTF8, "application/json")
                Dim response As HttpResponseMessage = client.PostAsync(apiUrl, content).Result

                responseContent = response.Content.ReadAsStringAsync().Result

                If response.IsSuccessStatusCode Then
                    Dim responseObject = JsonConvert.DeserializeObject(Of Dictionary(Of String, Object))(responseContent)
                    Dim id As String = responseObject("id").ToString()
                    '  txtnonota.Text = id
                    Return True ' Berhasil
                Else
                    Console.WriteLine($"Error: {response.StatusCode} - {response.ReasonPhrase}")
                    Return False ' Gagal
                End If
            End Using
        Catch ex As Exception
            responseContent = $"Exception: {ex.Message}"
            Console.WriteLine(responseContent)
            Return False ' Gagal karena exception
        End Try
    End Function

    Function cekprinter()
        Dim settings As PrinterSettings = New PrinterSettings()
        Dim paijo = settings.PrinterName
        Return paijo
    End Function

End Class