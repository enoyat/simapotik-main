Public Class FormCustomer
    Sub cari()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("namacustosmer", txtcari.Text)

        Dim respons = postData(urlprefix + "customer/getcustomer", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("idcustomer", GetType(String))
            data.Columns.Add("namacustomer", GetType(String))
            data.Columns.Add("kategori", GetType(String))
            For Each Row2 In respons("data")
                data.Rows.Add(Row2("idcustomer").ToString(),
                          Row2("namacustomer").ToString(),
                          Row2("kategori").ToString()
                          )
            Next
            DataGridView1.DataSource = data
            DataGridView1.Columns(1).Width = 300
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub

    Private Sub FormCustomer_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtcari.Text = "pela"
        Call cari()
        txtcari.Text = ""
        txtcari.Select()
    End Sub

    Private Sub txtcari_TextChanged(sender As Object, e As EventArgs) Handles txtcari.TextChanged

    End Sub

    Private Sub txtcari_KeyDown(sender As Object, e As KeyEventArgs) Handles txtcari.KeyDown
        If (e.KeyCode = Keys.Enter) Then

            If (Len(txtcari.Text) > 5) Then
                Call cari()
            End If
        End If
    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick

    End Sub

    Private Sub DataGridView1_KeyDown(sender As Object, e As KeyEventArgs) Handles DataGridView1.KeyDown

        If (e.KeyCode = Keys.Enter) Then
            If (caller.Text = "penjualan") Then
                FormPenjualan.txtkdcustomer.Text = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
                FormPenjualan.txtnamacustomer.Text = Convert.ToString(DataGridView1.Item(1, DataGridView1.CurrentRow.Index).Value)
                FormPenjualan.kategori.Text = Convert.ToString(DataGridView1.Item(2, DataGridView1.CurrentRow.Index).Value)
                FormPenjualan.ubahharga()
                Close()
            End If
            If (caller.Text = "penjualanresep") Then
                FormPenjualanResep.txtkdcustomer.Text = Convert.ToString(DataGridView1.Item(0, DataGridView1.CurrentRow.Index).Value)
                FormPenjualanResep.txtnamacustomer.Text = Convert.ToString(DataGridView1.Item(1, DataGridView1.CurrentRow.Index).Value)
                Close()
            End If

        End If
    End Sub
End Class