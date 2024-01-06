Imports Microsoft.Reporting.WinForms
Imports System.Drawing.Printing
Public Class FormPenjualan
    Dim WithEvents PD As New PrintDocument
    Dim PPD As New PrintPreviewDialog
    Dim jmltotal As Integer
    Dim jmldiskon As Integer

    Dim panjang As Integer
    Sub ubahharga()
        If (kategori.Text = "umum") Then
            cbjenisharga.Items.Clear()
            cbjenisharga.Items.Add("Harga HV")
            cbjenisharga.Items.Add("Harga Grosir")
            cbjenisharga.Items.Add("Harga Resep")
            cbjenisharga.SelectedIndex = 0
        End If
        If (kategori.Text = "khusus") Then
            cbjenisharga.Items.Clear()
            cbjenisharga.Items.Add("Harga Beli")
            cbjenisharga.SelectedIndex = 0
        End If

    End Sub
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
        Dim parameters = New Specialized.NameValueCollection
        parameters.Add("kdbarang", kode)
        parameters.Add("idlokasi", "TOKO")
        parameters.Add("nim", nim)
        Dim respons = postData(urlprefix + "barang/caribarang", "POST", parameters)
        Dim state = respons.SelectToken("success").ToString

        If state = "success" Then
            For Each Row2 In respons("data")
                xkdbarang = Row2("kdbarang").ToString()
                xnamabarang = Row2("namabarang").ToString()
                xqty = Row2("stok").ToString()

                If (xqty = 0) Then
                    MsgBox("stok barang tidak tersedia", vbOK, "Informasi")
                    txtkdbarang.Text = ""
                    Exit Sub

                End If
                If (cbjenisharga.Text = "Harga Grosir") Then
                    xharga = Row2("hargagrosir").ToString()
                ElseIf (cbjenisharga.Text = "Harga Resep") Then
                    xharga = Row2("hargaresep").ToString()
                ElseIf (cbjenisharga.Text = "Harga Beli") Then
                    xharga = Row2("hargabeli").ToString()
                Else
                    xharga = Row2("hargahv").ToString()
                End If
                If xnamabarang <> "" Then

                    Dim golongan = Row2("idgolongan").ToString()
                    qty = txtqty.Text
                    jumlah = xharga * qty
                    total = jumlah
                    Dim row As String() = New String() {xkdbarang, xnamabarang, xharga, qty, jumlah, "0", "0", total, golongan}
                    DataGridView1.Rows.Add(row)
                Else
                    MsgBox("Data tidak ditemukan", vbOK, "Informasi")

                End If
                Call hitung()
                txtkdbarang.Text = ""
                txtqty.Text = "1"
                txtkdbarang.Select()
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
        txtkdcustomer.Text = "C0001"
        txtnamacustomer.Text = "Pelanggan Umum"
        txtjmltotal.Text = 0
        txtdisplayjmltotal.Text = 0
        txtbayar.Text = 0
        txtkembali.Text = 0
        DataGridView1.Rows.Clear()
        tgltransaksi.Value = Now()
        txtkdbarang.Select()
        cbjenisharga.SelectedIndex = 0
        btncetak.Enabled = False
        btnsimpan.Enabled = False
        ubahharga()
        combotipepenjualan.Text = "T"
        txtbayar.Enabled = True
    End Sub

    ''' <summary>
    ''' 
    ''' </summary>
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
                FormBarang.Close()
            FormBarang.ShowDialog()
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
        If (kategori.Text = "khusus") Then
            cetakrdlc()
        Else
            ubahpanjang()
            PPD.Document = PD
            ' PPD.ShowDialog()
            PD.Print()
        End If


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
        Dim hargagolongan = 0
        garis = "----------------------------------------------------------------------------"

        e.Graphics.DrawString("APOTEK SEHATI", f14, Brushes.Black, centermargin, 5, tengah)
        e.Graphics.DrawString("Jl. Kol. Sugiono No. 2B PATI", f10, Brushes.Black, centermargin, 25, tengah)
        e.Graphics.DrawString("Telp. (0295) 392166 WA: 08112901281", f10, Brushes.Black, centermargin, 40, tengah)

        e.Graphics.DrawString("NOTA APOTEK", f10, Brushes.Black, 0, 60)
        e.Graphics.DrawString(tgltransaksi.Value, f10, Brushes.Black, 0, 75)
        e.Graphics.DrawString("NPWP: 02.908.598.2-507.000", f10, Brushes.Black, 0, 90)
        e.Graphics.DrawString("Harga sudah termasuk PPN", f10, Brushes.Black, 0, 105)
        e.Graphics.DrawString("No. Nota", f10, Brushes.Black, 0, 125)
        e.Graphics.DrawString(":", f10, Brushes.Black, 65, 125)
        e.Graphics.DrawString(txtnonota.Text, f10, Brushes.Black, 65, 125)
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, 135)
        e.Graphics.DrawString("Qty", f10, Brushes.Black, 0, 150)
        e.Graphics.DrawString("Nama", f10, Brushes.Black, 25, 150)
        e.Graphics.DrawString("Harga", f10, Brushes.Black, 180, 150)
        e.Graphics.DrawString(garis, f10, Brushes.Black, 0, 165)
        Dim jmldata As Integer
        jmldata = DataGridView1.Rows.Count
        Dim tinggi As Integer
        Dim i As Long

        For baris As Integer = 0 To jmldata - 1
            If (DataGridView1.Rows(baris).Cells(8).Value.ToString = "G0001" Or DataGridView1.Rows(baris).Cells(8).Value.ToString = "G0004") Or DataGridView1.Rows(baris).Cells(8).Value.ToString = "G0006" Then
                hargagolongan = hargagolongan + (DataGridView1.Rows(baris).Cells(7).Value)
            Else
                tinggi += 15
                e.Graphics.DrawString(DataGridView1.Rows(baris).Cells(3).Value.ToString, f10, Brushes.Black, 0, 165 + tinggi)
                Dim jmlnamabarang = Len(DataGridView1.Rows(baris).Cells(1).Value.ToString)
                If jmlnamabarang > 30 Then
                    Dim namabarangpendek = DataGridView1.Rows(baris).Cells(1).Value.ToString

                    e.Graphics.DrawString(namabarangpendek.Substring(0, Math.Min(30, namabarangpendek.Length)), f10, Brushes.Black, 25, 165 + tinggi)
                Else
                    e.Graphics.DrawString(DataGridView1.Rows(baris).Cells(1).Value.ToString, f10, Brushes.Black, 25, 165 + tinggi)
                End If
                i = DataGridView1.Rows(baris).Cells(7).Value
                DataGridView1.Rows(baris).Cells(7).Value = Format(i, "##,##0")
                e.Graphics.DrawString(DataGridView1.Rows(baris).Cells(7).Value.ToString, f10, Brushes.Black, rigtmargin, 165 + tinggi, kanan)
            End If
        Next
        If (hargagolongan > 0) Then
            tinggi += 15
            e.Graphics.DrawString("1", f10, Brushes.Black, 0, 165 + tinggi)
            e.Graphics.DrawString("Obat-Obatan", f10, Brushes.Black, 25, 165 + tinggi)
            e.Graphics.DrawString(Format(hargagolongan, "##,##0"), f10, Brushes.Black, rigtmargin, 165 + tinggi, kanan)
        End If
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

    End Sub
    Function cekstok(kode, inqty)
        Dim xkdbarang, xnamabarang As String
        Dim xharga, xqty, jumlah, qty, total As Int32
        Dim url = urlprefix + "barang/" + kode
        Dim jsonObject = getData(url)
        Dim isdata = jsonObject.SelectToken("data")

        If (isdata.Count > 0) Then
            xkdbarang = jsonObject.SelectToken("data")("kdbarang").ToString
            xnamabarang = jsonObject.SelectToken("data")("namabarang").ToString
            xqty = jsonObject.SelectToken("data")("stok").ToString
            If (xqty = 0) Then
                Return False
            ElseIf (int(xqty) < int(inqty)) Then
                Return False
            End If
            Return True
        Else
            MsgBox("Data tidak ditemukan", vbOK, "Informasi")
            txtkdbarang.Text = ""
            txtqty.Text = "1"
            txtkdbarang.Select()
        End If
    End Function
    Private Sub DataGridView1_CellEnter(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellEnter
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
                MsgBox("cek stok")
                DataGridView1.Item(3, selectedrow).Value = 1

            End If


        Catch ex As Exception

        End Try

    End Sub

    Private Sub btnsimpan_Click(sender As Object, e As EventArgs) Handles btnsimpan.Click
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
        parameters.Add("tipepenjualan", combotipepenjualan.Text)



        Dim respons = postData(urlprefix + "penjualan/store", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim lastid As Integer = respons("data")("lastid")
            txtnonota.Text = lastid
            '  Dim parameteritems = New Specialized.NameValueCollection
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

                respons = postData(urlprefix + "penjualan/storeitem", "POST", parameteritems)
            Next

            MsgBox("Simpan Data Sukses")
            If (kategori.Text = "khusus") Then
                cetakrdlc()
            Else
                PD.Print()
            End If
            btnsimpan.Enabled = False
            txtbayar.Enabled = False
            btncetak.Enabled = True
            btnclear.Select()
        Else
                MsgBox("ada kesahalan data")
        End If


    End Sub

    Private Sub txtbayar_TextChanged(sender As Object, e As EventArgs) Handles txtbayar.TextChanged

    End Sub

    Private Sub Button4_Click(sender As Object, e As EventArgs) Handles Button4.Click
        FormCustomer.Close()
        FormCustomer.caller.Text = "penjualan"
        FormCustomer.ShowDialog()
    End Sub

    Private Sub btnpending_Click(sender As Object, e As EventArgs) Handles btnpending.Click
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

    Private Sub btnambilpending_Click(sender As Object, e As EventArgs) Handles btnambilpending.Click
        FormPending.Close()
        FormPending.ShowDialog()
    End Sub
End Class