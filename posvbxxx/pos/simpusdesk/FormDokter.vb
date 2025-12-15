Public Class FormDokter
    Sub cari()
        Dim parameters = New Specialized.NameValueCollection

        parameters.Add("kdpst", "00001")
        parameters.Add("namadokter", txtcari.Text)

        Dim respons = postData(urlprefix + "dokter/getdokter", "POST", parameters)
        Dim state = respons.SelectToken("status").ToString
        If state = "success" Then
            Dim data As New DataTable
            data.Columns.Add("iddokter", GetType(String))
            data.Columns.Add("namadokter", GetType(String))
            For Each Row2 In respons("data")
                data.Rows.Add(Row2("iddokter").ToString(),
                          Row2("namadokter").ToString()
                          )
            Next
            DataGridView1.DataSource = data
            DataGridView1.Columns(1).Width = 300
        Else
            MsgBox("ada kesahalan data")
        End If

    End Sub
    Private Sub Label1_Click(sender As Object, e As EventArgs) Handles Label1.Click

    End Sub

    Private Sub FormDokter_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtcari.Text = "DR"
        Call cari()
        txtcari.Text = ""
        txtcari.Select()
    End Sub
    Private Sub txtcari_KeyDown(sender As Object, e As KeyEventArgs) Handles txtcari.KeyDown
        If (e.KeyCode = Keys.Enter) Then

            If (Len(txtcari.Text) > 2) Then
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

    Private Sub txtcari_TextChanged(sender As Object, e As EventArgs) Handles txtcari.TextChanged

    End Sub
End Class