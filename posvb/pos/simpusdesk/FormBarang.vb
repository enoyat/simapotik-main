Public Class FormBarang
    Sub cari()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("namabarang", txtcari.Text)
        parameters.Add("idlokasi", "TOKO")
        parameters.Add("nim", nim)



        Dim respons = postData(urlprefix + "barang/getbarang", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("kdbarang", GetType(String))
            data.Columns.Add("namabarang", GetType(String))
            data.Columns.Add("hargahv", GetType(String))
            data.Columns.Add("hargagrosir", GetType(String))
            data.Columns.Add("hargaresep", GetType(String))
            data.Columns.Add("stoktoko", GetType(String))


            For Each Row2 In respons("data")
                data.Rows.Add(Row2("kdbarang").ToString(),
                          Row2("namabarang").ToString(),
                          Row2("hargahv").ToString(),
                          Row2("hargagrosir").ToString(),
                          Row2("hargaresep").ToString(),
                          Row2("stok").ToString()
                          )
            Next
            DataGridView1.DataSource = data
            DataGridView1.Columns(1).Width = 300
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub

    Private Sub FormBarang_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtcari.Text = "aa"
        Call cari()
        txtcari.Text = ""
        txtcari.Select()


    End Sub

    Private Sub txtcari_KeyDown(sender As Object, e As KeyEventArgs) Handles txtcari.KeyDown
        If (e.KeyCode = Keys.Enter) Then
            If (Len(txtcari.Text) > 3) Then
                Call cari()
            End If
        ElseIf (e.KeyCode = Keys.up) Then
            DataGridView1.Select()
        End If
    End Sub



    Private Sub DataGridView1_KeyDown(sender As Object, e As KeyEventArgs) Handles DataGridView1.KeyDown
        If (e.KeyCode = Keys.Enter) Then
            FormPenjualan.txtkdbarang.Text = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
            Close()
        ElseIf (e.KeyCode = Keys.tab) Then
            txtcari.Select()
        End If
    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick

    End Sub

    Private Sub txtcari_TextChanged(sender As Object, e As EventArgs) Handles txtcari.TextChanged

    End Sub
End Class