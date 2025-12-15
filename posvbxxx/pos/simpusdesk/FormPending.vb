Public Class FormPending
    Sub cari()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("email", FormPenjualanResep.txtkasir.Text)

        Dim respons = postData(urlprefix + "penjualan/getpending", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("id", GetType(String))
            data.Columns.Add("idcustomer", GetType(String))
            data.Columns.Add("namacustomer", GetType(String))
            data.Columns.Add("tgltrans", GetType(String))
            data.Columns.Add("jam", GetType(String))
            data.Columns.Add("email", GetType(String))
            data.Columns.Add("total", GetType(String))

            For Each Row2 In respons("data")
                data.Rows.Add(Row2("id").ToString(),
                          Row2("idcustomer").ToString(),
                          Row2("get_customer")("namacustomer").ToString(),
                          Row2("tgltrans").ToString(),
                          Row2("jam").ToString(),
                          Row2("email").ToString(),
                          Row2("total").ToString())
            Next
            DataGridView1.DataSource = data
            DataGridView1.Columns(1).Width = 100
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub
    Sub cariitem(id)
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("id", id)



        Dim respons = postData(urlprefix + "penjualan/getitempending", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("kdbarang", GetType(String))
            data.Columns.Add("namabarang", GetType(String))
            data.Columns.Add("harga", GetType(String))
            data.Columns.Add("qty", GetType(String))
            data.Columns.Add("diskonpersen", GetType(String))
            data.Columns.Add("diskon", GetType(String))
            data.Columns.Add("jumlah", GetType(String))

            For Each Row2 In respons("data")
                data.Rows.Add(Row2("kdbarang").ToString(),
                          Row2("get_barang")("namabarang").ToString(),
                          Row2("harga").ToString(),
                          Row2("qty").ToString(),
                          Row2("diskonpersen").ToString(),
                          Row2("diskon").ToString(),
                          Row2("jumlah").ToString())
            Next
            DataGridView2.DataSource = data
            DataGridView2.Columns(1).Width = 100
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub
    Sub hapuspending(id)
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("id", id)



        Dim respons = postData(urlprefix + "penjualan/hapuspending", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            cari()
            MsgBox("Hapus Sukses")
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub
    Private Sub FormPending_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Call cari()
    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick
        Dim id = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
        cariitem(id)
    End Sub

    Private Sub DataGridView1_KeyDown(sender As Object, e As KeyEventArgs) Handles DataGridView1.KeyDown
        Dim id = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
        If (e.KeyCode = Keys.Enter) Then
            cariitem(id)
        ElseIf (e.KeyCode = Keys.F5) Then
            hapuspending(id)
        End If
    End Sub

    Private Sub btnpilih_Click(sender As Object, e As EventArgs) Handles btnpilih.Click
        FormPenjualanResep.bersih()
        Dim xkdbarang, xnamabarang As String
        Dim xharga, jumlah, qty, diskonpersen, diskon, total As Int32
        FormPenjualanResep.txtkdcustomer.Text = DataGridView1.Item(1, DataGridView1.CurrentRow.Index).Value
        FormPenjualanResep.txtnamacustomer.Text = DataGridView1.Item(2, DataGridView1.CurrentRow.Index).Value
        For i As Integer = 0 To DataGridView2.Rows.Count - 1
            xkdbarang = DataGridView2.Item(0, i).Value
            xnamabarang = DataGridView2.Item(1, i).Value
            xharga = DataGridView2.Item(2, i).Value
            qty = DataGridView2.Item(3, i).Value
            jumlah = xharga * qty
            diskonpersen = DataGridView2.Item(4, i).Value
            diskon = DataGridView2.Item(5, i).Value
            total = DataGridView2.Item(6, i).Value
            Dim row As String() = New String() {xkdbarang, xnamabarang, xharga, qty, jumlah, diskonpersen, diskon, total}
            FormPenjualanResep.DataGridView1.Rows.Add(row)

            FormPenjualanResep.hitung()
            Close()
        Next
    End Sub
End Class