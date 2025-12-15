Imports Microsoft.Reporting.WinForms
Imports System.Drawing.Printing
Imports Newtonsoft.Json
Imports System.Net.Http
Imports System.Text

Public Class FormPenjualanResep
    Dim WithEvents PD As New PrintDocument
    Dim PPD As New PrintPreviewDialog
    Dim jmltotal As Integer
    Dim jmldiskon As Integer
    Dim panjang As Integer
    Dim ardokter(100) As Integer
    Sub ubahpanjang()
        Dim rowcount As Integer
        panjang = 0
        rowcount = DataGridView1.Rows.Count
        panjang = rowcount * 15
        panjang = panjang + 300
    End Sub

    Sub CariBarang(kode)
        Dim xkdbarang, xnamabarang As String
        Dim xharga, xqty, jumlah, qty, total As Int32
        Dim lokasi = ComboLokasi.SelectedIndex
        Dim asallokasi As String
        If (lokasi = 0) Then
            asallokasi = "TOKO"
        Else
            asallokasi = "G4"
        End If

        Dim parameters = New Specialized.NameValueCollection
        parameters.Add("kdbarang", kode)
        parameters.Add("idlokasi", asallokasi)
        parameters.Add("nim", nim)
        Dim respons = postData(urlprefix + "barang/caribarang", "POST", parameters)
        Dim state = respons.SelectToken("success").ToString

        If state = "success" Then
            For Each Row2 In respons("data")
                xkdbarang = Row2("kdbarang").ToString()
                xnamabarang = Row2("namabarang").ToString()
                xqty = Row2("stok").ToString()
                xharga = Row2("hargaresep").ToString()


                If (xqty = 0) Then
                    MsgBox("stok barang tidak tersedia", vbOK, "Informasi")
                    txtkdbarang.Text = ""
                    Exit Sub

                End If
                If xnamabarang <> "" Then
                    qty = txtqty.Text
                    jumlah = xharga * qty
                    total = jumlah
                    Dim row As String() = New String() {xkdbarang, xnamabarang, xharga, qty, jumlah, "0", "0", total}
                    DataGridView1.Rows.Add(row)
                    Call hitung()
                Else
                    MsgBox("Data tidak ditemukan", vbOK, "Informasi")
                    Call hitung()
                    txtkdbarang.Text = ""
                    txtqty.Text = "1"
                    txtkdbarang.Select()
                End If
            Next
        Else
            MsgBox("Data tidak ditemukan", vbOK, "Informasi")
            txtkdbarang.Text = ""
            txtqty.Text = "1"
            txtkdbarang.Select()
        End If
    End Sub
    Private Sub DataGridView1_KeyDown(sender As Object, e As KeyEventArgs) Handles DataGridView1.KeyDown
        Try
            Dim selectedrow As Integer = DataGridView1.CurrentCell.RowIndex
            Dim selectedcol As Integer = DataGridView1.CurrentCell.ColumnIndex

            If (e.KeyCode = Keys.F5) Then
                If (selectedrow > -1) Then
                    DataGridView1.Rows.RemoveAt(selectedrow)
                    DataGridView1.Refresh()
                End If
            End If

        Catch ex As Exception
            MsgBox("ada kesalahan : " + ex.ToString)

        End Try

    End Sub

    Private Sub TextBox3_KeyDown(sender As Object, e As KeyEventArgs)

    End Sub

    Private Sub FormPenjualan_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtkdbarang.Select()
        cbjenisharga.SelectedIndex = 0
        txtkasir.Text = FormUtama.ToolStripStatusLabel1.Text

        Call bersih()

    End Sub
    Sub bersih()
        txtkdcustomer.Text = "P0001"
        txtnamacustomer.Text = "Pelanggan Umum"
        txtnamapasien.Text = ""
        txtiddokter.Text = ""
        txtjmltotal.Text = 0
        txtdisplayjmltotal.Text = 0
        txtbayar.Text = 0
        txtkembali.Text = 0
        DataGridView1.Rows.Clear()
        tgltransaksi.Value = Now()
        txtkdbarang.Select()
        cbjenisharga.SelectedIndex = 0
        combotipepenjualan.SelectedIndex = 0
        btncetak.Enabled = False
        btnsimpan.Enabled = False
        ComboLokasi.SelectedIndex = 0
        txtiddokter.Text = ""
        txtnamadokter.Text = ""
        txtbayar.Enabled = True


    End Sub

    Sub hitung()
        Try
            jmltotal = 0
            jmldiskon = 0
            Dim jmldata As Integer
            jmldata = DataGridView1.Rows.Count

            For i = 0 To jmldata - 1
                jmldiskon += Int(DataGridView1.Item(6, i).Value)
                jmltotal += Int(DataGridView1.Item(7, i).Value)

            Next
            'Dim nilai = jmltotal Mod 500
            'If (nilai > 0 & nilai < 500) Then
            '    jmltotal = Math.Round(jmltotal / 500) * 500 + 500
            'Else
            '    jmltotal = Math.Round(jmltotal / 500) * 500
            'End If



            txtjmltotal.Text = jmltotal.ToString()
            TextDiskon.Text = jmldiskon.ToString
            txtdisplayjmltotal.Text = jmltotal.ToString("#,##0")

        Catch ex As Exception

        End Try
    End Sub
    Sub hitungitem()
        Try
            txtjmltotal.Text = jmltotal.ToString()
            txtdisplayjmltotal.Text = jmltotal.ToString("#,##0")

        Catch ex As Exception

        End Try
    End Sub
    Private Sub txtkdbarang_TextChanged(sender As Object, e As EventArgs) Handles txtkdbarang.TextChanged

    End Sub

    Private Sub txtkdbarang_KeyDown(sender As Object, e As KeyEventArgs) Handles txtkdbarang.KeyDown


        If (e.KeyCode = Keys.Enter) Then
            If (txtkdbarang.Text <> "") Then
                Call CariBarang(txtkdbarang.Text)
            End If
        ElseIf (e.KeyCode = Keys.Add) Then
            txtbayar.Select()
        ElseIf (e.KeyCode = Keys.F2) Then
            FormBarangResep.Close()
            FormBarangResep.ShowDialog()
        End If
    End Sub

    Private Sub txtbayar_KeyDown(sender As Object, e As KeyEventArgs) Handles txtbayar.KeyDown
        If (e.KeyCode = Keys.Enter) Then
            If (txtbayar.Text = "") Then
                Exit Sub
            End If
            If (Int(txtbayar.Text) < Int(txtjmltotal.Text)) Then
                MsgBox("uangnya kurang")
            Else
                Dim kembali As Integer = Int(txtbayar.Text) - Int(txtjmltotal.Text)
                txtkembali.Text = kembali.ToString("#,##0")
                btnsimpan.Enabled = True
                btnsimpan.Select()
            End If
        End If
    End Sub

    Private Sub Button3_Click(sender As Object, e As EventArgs) Handles btnclear.Click
        Call bersih()
    End Sub

    Sub cetakrdlc()
        Dim barcode = New BarcodeLib.Barcode()
        Dim data As New DataTable
        Dim jmldata As Integer
        jmldata = DataGridView1.Rows.Count

        Dim kdbarang, namabarang As String
        Dim qty, harga, jumlah, disc1, disc2, total As Integer
        data.Columns.Add("kdbarang", GetType(String))
        data.Columns.Add("namabarang", GetType(String))
        data.Columns.Add("qty", GetType(Integer))
        data.Columns.Add("harga", GetType(Integer))
        data.Columns.Add("jumlah", GetType(Integer))
        data.Columns.Add("disc1", GetType(Integer))
        data.Columns.Add("disc2", GetType(Integer))
        data.Columns.Add("total", GetType(Integer))
        For i = 0 To jmldata - 1
            kdbarang = DataGridView1.Item(0, i).Value
            namabarang = DataGridView1.Item(1, i).Value
            qty = DataGridView1.Item(3, i).Value
            harga = DataGridView1.Item(2, i).Value
            jumlah = DataGridView1.Item(4, i).Value
            disc1 = DataGridView1.Item(5, i).Value
            disc2 = DataGridView1.Item(6, i).Value
            total = DataGridView1.Item(7, i).Value

            data.Rows.Add(kdbarang, namabarang, qty, harga, jumlah, disc1, disc2, total)
        Next

        Dim parms = New ReportParameterCollection
        parms.Add(New ReportParameter("pnonota", "test"))
        parms.Add(New ReportParameter("pnonota", "test"))

        FormInvoice.ReportViewer1.LocalReport.SetParameters(parms)


        FormInvoice.ReportViewer1.LocalReport.DataSources.Clear()
        FormInvoice.ReportViewer1.LocalReport.DataSources.Add(New ReportDataSource("DataSet1", data))
        FormInvoice.ReportViewer1.LocalReport.EnableExternalImages = True
        FormInvoice.ReportViewer1.LocalReport.Refresh()
        FormInvoice.ShowDialog()
    End Sub

    Private Sub btncetak_Click(sender As Object, e As EventArgs) Handles btncetak.Click
        ubahpanjang()
        PPD.Document = PD
        'PPD.ShowDialog()
        PD.Print()

    End Sub

    Private Sub PD_PrintPage(sender As Object, e As PrintPageEventArgs) Handles PD.PrintPage
        Dim f10 As New Font("Times New Roman", 8, FontStyle.Regular)
        Dim f6 As New Font("Times New Roman", 6, FontStyle.Regular)
        Dim f10b As New Font("Times New Roman", 8, FontStyle.Bold)
        Dim f14 As New Font("Times New Roman", 14, FontStyle.Bold)
        Dim leftmargin As Integer = PD.DefaultPageSettings.Margins.Left
        Dim centermargin As Integer = PD.DefaultPageSettings.PaperSize.Width / 2
        Dim rigtmargin As Integer = PD.DefaultPageSettings.PaperSize.Width

        Dim kanan As New StringFormat
        Dim tengah As New StringFormat
        kanan.Alignment = StringAlignment.Far
        tengah.Alignment = StringAlignment.Center
        Dim garis As String
        garis = "----------------------------------------------------------------------------"

        e.Graphics.DrawString(toko, f14, Brushes.Black, centermargin, 5, tengah)
        e.Graphics.DrawString(alamat, f10, Brushes.Black, centermargin, 25, tengah)
        e.Graphics.DrawString(telpon, f10, Brushes.Black, centermargin, 40, tengah)

        e.Graphics.DrawString("NOTA APOTEK", f10, Brushes.Black, 0, 60)
        e.Graphics.DrawString(tgltransaksi.Value, f10, Brushes.Black, 0, 75)
        e.Graphics.DrawString(npwp, f10, Brushes.Black, 0, 90)
        e.Graphics.DrawString("Harga sudah termasuk PPN", f10, Brushes.Black, 0, 105)
        e.Graphics.DrawString("Pro ", f10, Brushes.Black, 0, 125)
        e.Graphics.DrawString(":", f10, Brushes.Black, 65, 125)
        e.Graphics.DrawString(txtnamapasien.Text, f10, Brushes.Black, 65, 125)

        e.Graphics.DrawString("No. Nota", f10, Brushes.Black, 0, 135)
        e.Graphics.DrawString(":", f10, Brushes.Black, 45, 135)
        e.Graphics.DrawString(txtnonota.Text, f10, Brushes.Black, 50, 135)

        e.Graphics.DrawString("dokter", f10, Brushes.Black, 100, 135)
        e.Graphics.DrawString(txtnamadokter.Text, f10, Brushes.Black, 160, 135)


        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, 145)

        'Dim jmldata As Integer
        'jmldata = DataGridView1.Rows.Count
        Dim tinggi As Integer
        'Dim i As Long

        'For baris As Integer = 0 To jmldata - 1
        '    tinggi += 15
        e.Graphics.DrawString("Obat Resep", f10, Brushes.Black, 0, 165 + tinggi)
        '    e.Graphics.DrawString(DataGridView1.Rows(baris).Cells(1).Value.ToString, f10, Brushes.Black, 25, 165 + tinggi)

        '    i = DataGridView1.Rows(baris).Cells(7).Value
        '    DataGridView1.Rows(baris).Cells(7).Value = Format(i, "##,##0")
        e.Graphics.DrawString(Format(jmltotal, "##,##0"), f10, Brushes.Black, rigtmargin, 165 + tinggi, kanan)
        'Next
        tinggi = 180 + tinggi
        Dim bayar = Int(txtbayar.Text)
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, tinggi)
        e.Graphics.DrawString(txtkasir.Text, f6, Brushes.Black, 0, 10 + tinggi)
        e.Graphics.DrawString("Total : ", f10b, Brushes.Black, 120, 10 + tinggi)
        e.Graphics.DrawString(Format(jmltotal, "##,##0"), f10b, Brushes.Black, rigtmargin, 10 + tinggi, kanan)
        e.Graphics.DrawString("Diskon: ", f10b, Brushes.Black, 120, 20 + tinggi)
        e.Graphics.DrawString(Format(jmldiskon, "##,##0"), f10b, Brushes.Black, rigtmargin, 20 + tinggi, kanan)
        e.Graphics.DrawString("Bayar : ", f10b, Brushes.Black, 120, 30 + tinggi)
        e.Graphics.DrawString(Format(bayar, "##,##0"), f10b, Brushes.Black, rigtmargin, 30 + tinggi, kanan)
        e.Graphics.DrawString("Kembalian : ", f10b, Brushes.Black, 120, 40 + tinggi)
        e.Graphics.DrawString(txtkembali.Text, f10b, Brushes.Black, rigtmargin, 40 + tinggi, kanan)

        e.Graphics.DrawString("Mohon periksa kembalian dan barang yang telah", f10, Brushes.Black, 0, 60 + tinggi)
        e.Graphics.DrawString("dibeli tidak bisa dikembalikan", f10, Brushes.Black, 0, 70 + tinggi)
        e.Graphics.DrawString("SEMOGA LEKAS SEMBUH", f10, Brushes.Black, 0, 80 + tinggi)
        e.Graphics.DrawString("~ 0 ~", f10, Brushes.Black, centermargin, 100 + tinggi)
    End Sub

    Private Sub PD_BeginPrint(sender As Object, e As PrintEventArgs) Handles PD.BeginPrint
        Dim pagesetup As New PageSettings
        pagesetup.PaperSize = New PaperSize("Custom", 280, panjang)
        PD.DefaultPageSettings = pagesetup
    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick

    End Sub

    Private Sub DataGridView1_KeyPress(sender As Object, e As KeyPressEventArgs) Handles DataGridView1.KeyPress
        If e.KeyChar = Microsoft.VisualBasic.ChrW(Keys.Return) Then
            SendKeys.Send("{TAB}")
            e.Handled = True
        End If
    End Sub
    Function cekstok(kode, inqty)
        Dim xkdbarang, xnamabarang As String
        Dim xharga, xqty, jumlah, qty, total As Int32
        Dim lokasi = ComboLokasi.SelectedIndex
        Dim asallokasi As String
        If (lokasi = 0) Then
            asallokasi = "TOKO"
        Else
            asallokasi = "G4"
        End If

        Dim parameters = New Specialized.NameValueCollection
        parameters.Add("kdbarang", kode)
        parameters.Add("idlokasi", asallokasi)
        parameters.Add("nim", nim)
        Dim respons = postData(urlprefix + "barang/caribarang", "POST", parameters)
        Dim state = respons.SelectToken("success").ToString

        If state = "success" Then
            For Each Row2 In respons("data")
                xkdbarang = Row2("kdbarang").ToString()
                xnamabarang = Row2("namabarang").ToString()
                xqty = Row2("stok").ToString()
                If (xqty = 0) Then
                    Return False
                ElseIf (Int(xqty) < Int(inqty)) Then
                    Return False
                Else
                    Return True
                End If
            Next
        Else
            MsgBox("Data tidak ditemukan", vbOK, "Informasi")
            txtkdbarang.Text = ""
            txtqty.Text = "1"
            txtkdbarang.Select()
        End If
    End Function
    Sub cellenter()
        Try
            Dim selectedrow As Integer = DataGridView1.CurrentCell.RowIndex
            Dim selectedcol As Integer = DataGridView1.CurrentCell.ColumnIndex
            Dim qty, jumlah, harga, total, disk1, disk2, diskperson As Integer

            qty = Int(DataGridView1.Item(3, selectedrow).Value)
            If (cekstok(DataGridView1.Item(0, selectedrow).Value, qty) = True) Then
                harga = Int(DataGridView1.Item(2, selectedrow).Value)
                disk1 = Int(DataGridView1.Item(5, selectedrow).Value)
                disk2 = Int(DataGridView1.Item(6, selectedrow).Value)
                If (disk1 > 0) Then
                    diskperson = (harga * qty) * disk1 / 100
                    DataGridView1.Item(6, selectedrow).Value = diskperson
                    disk2 = diskperson
                End If
                jumlah = (harga * qty) - disk2
                total = jumlah
                DataGridView1.Item(4, selectedrow).Value = (harga * qty)
                DataGridView1.Item(7, selectedrow).Value = total
                hitung()
            Else
                MsgBox("stok tidak tersedia")
                DataGridView1.Item(3, selectedrow).Value = 1

            End If

        Catch ex As Exception

        End Try
    End Sub
    Private Sub DataGridView1_CellEnter(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellEnter


    End Sub

    Private Sub btnsimpan_Click(sender As Object, e As EventArgs) Handles btnsimpan.Click


        Dim modebayar As String
        If CheckBox1.Checked = True Then
            modebayar = "NON TUNAI"
        Else
            modebayar = "TUNAI"
        End If
        If (txtiddokter.Text = "") Then
            MsgBox("Belum memilih DOkter")
            Exit Sub
        End If
        btnsimpan.Enabled = False


        ' Mengumpulkan data untuk Items dari DataGridView1
        Dim items As New List(Of Dictionary(Of String, String))
        Dim jmldata As Integer = DataGridView1.Rows.Count

        For i As Integer = 0 To jmldata - 1
            Dim idlokasi = ""
            If (ComboLokasi.SelectedIndex = 0) Then
                idlokasi = "TOKO"
            Else
                idlokasi = "G4"
            End If
            Dim item As New Dictionary(Of String, String) From {
                    {"kdbarang", DataGridView1.Item(0, i).Value},
                    {"qty", DataGridView1.Item(3, i).Value},
                    {"harga", DataGridView1.Item(2, i).Value},
                    {"diskonpersen", DataGridView1.Item(5, i).Value},
                    {"diskon", DataGridView1.Item(6, i).Value},
                    {"jumlah", DataGridView1.Item(7, i).Value},
                    {"idlokasi", idlokasi}
                }
            items.Add(item)
        Next

        ' Membuat dictionary utama untuk JSON
        Dim datapenjualan As New Dictionary(Of String, Object) From {
                    {"idcustomer", txtkdcustomer.Text},
                    {"total", jmltotal},
                    {"email", txtkasir.Text},
                    {"modebayar", modebayar},
                    {"tgltrans", tgltransaksi.Value},
                    {"tipepenjualan", combotipepenjualan.Text},
                    {"Items", items}
            }

        ' Serialize ke JSON string
        Dim jsonString As String = JsonConvert.SerializeObject(datapenjualan, Formatting.Indented)

        ' Kirim ke API
        Dim apiUrl As String = urlprefix + "penjualan/store" ' Ganti dengan URL API Anda
        Dim responseContent As String = ""
        'Console.WriteLine(jsonString)
        Dim isSuccess As Boolean = SendJsonToApi(apiUrl, jsonString, responseContent)

        If isSuccess Then
            MsgBox("Simpan Sukses")
            ' Dim lastid As Integer = respons("data")("lastid")
            'txtnonota.Text = lastid
            Dim parameterreseps = New Specialized.NameValueCollection
            parameterreseps.Add("idpenjualan", txtnonota.Text)
            parameterreseps.Add("noresep", txtnonota.Text)
            parameterreseps.Add("iddokter", txtiddokter.Text)
            parameterreseps.Add("namapasien", txtnamapasien.Text)
            parameterreseps.Add("tipepenjualan", combotipepenjualan.Text)

            parameterreseps.Add("idpoly", "1")
            parameterreseps.Add("idjenispasien", "1")
            postData(urlprefix + "penjualan/storeresep", "POST", parameterreseps)


            'MsgBox("Simpan Data Sukses")
            'PPD.ShowDialog()
            PD.Print()
            btnsimpan.Enabled = False
            txtbayar.Enabled = False
            btncetak.Enabled = True
            btnclear.Select()

        Else
            ' API gagal
            MsgBox($"Gagal simpan. Respon: {responseContent}")
        End If




    End Sub

    Private Sub txtbayar_TextChanged(sender As Object, e As EventArgs) Handles txtbayar.TextChanged

    End Sub

    Private Sub Button4_Click(sender As Object, e As EventArgs)
        FormCustomer.Close()
        FormCustomer.ShowDialog()
    End Sub

    Private Sub btnpending_Click(sender As Object, e As EventArgs)
        Dim modebayar As String
        If CheckBox1.Checked = True Then
            modebayar = "NON TUNAI"
        Else
            modebayar = "TUNAI"
        End If
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("idcustomer", txtkdcustomer.Text)
        parameters.Add("total", jmltotal)
        parameters.Add("email", txtkasir.Text)
        parameters.Add("modebayar", modebayar)
        parameters.Add("tgltrans", tgltransaksi.Value)


        Dim respons = postData(urlprefix + "penjualan/storepending", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim lastid As Integer = respons("data")("lastid")
            txtnonota.Text = lastid
            'Dim parameteritems = New Specialized.NameValueCollection
            Dim jmldata As Integer = DataGridView1.Rows.Count
            For i As Integer = 0 To jmldata - 1
                Dim parameteritems = New Specialized.NameValueCollection
                parameteritems.Add("idpenjualan", lastid)
                parameteritems.Add("kdbarang", DataGridView1.Item(0, i).Value)
                parameteritems.Add("qty", DataGridView1.Item(3, i).Value)
                parameteritems.Add("harga", DataGridView1.Item(2, i).Value)
                parameteritems.Add("diskonpersen", DataGridView1.Item(5, i).Value)
                parameteritems.Add("diskon", DataGridView1.Item(6, i).Value)
                parameteritems.Add("jumlah", DataGridView1.Item(7, i).Value)
                parameteritems.Add("idlokasi", "TOKO")

                respons = postData(urlprefix + "penjualan/storependingitem", "POST", parameteritems)
            Next
            Call bersih()
            MsgBox("Pending Data Sukses")

        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub

    Private Sub btnambilpending_Click(sender As Object, e As EventArgs)
        FormPending.Close()
        FormPending.ShowDialog()
    End Sub


    Private Sub Button4_Click_1(sender As Object, e As EventArgs) Handles Button4.Click
        FormDokter.Close()
        FormDokter.caller.Text = "penjualan"
        FormDokter.ShowDialog()
    End Sub

    Private Sub DataGridView1_CellEndEdit(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellEndEdit
        Call cellenter()
    End Sub

    Private Sub PrintDocument1_PrintPage(sender As Object, e As PrintPageEventArgs) Handles PrintDocument1.PrintPage

    End Sub

    Private Sub PrintDocument1_BeginPrint(sender As Object, e As PrintEventArgs) Handles PrintDocument1.BeginPrint

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
                    txtnonota.Text = id
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
End Class