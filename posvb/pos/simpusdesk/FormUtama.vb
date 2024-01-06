Public Class FormUtama
    Private Sub ExitToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles ExitToolStripMenuItem.Click

        Dim answer As Integer
        answer = MsgBox("Yakin Keluar?", vbQuestion + vbYesNo + vbDefaultButton2, "Konfirmasi")
        If answer = vbYes Then
            Application.Exit()
        Else

        End If

    End Sub

    Private Sub LoginToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles LoginToolStripMenuItem.Click
        FormLogin.Close()
        FormLogin.ShowDialog()
    End Sub

    Private Sub FormUtama_Activated(sender As Object, e As EventArgs) Handles Me.Activated
        ToolStripStatusLabel1.Text = username
        ToolStripStatusLabel2.Text = "Role: " + role_id

    End Sub

    Private Sub ToolStripButton1_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub ToolStripButton6_Click(sender As Object, e As EventArgs)
    End Sub

    Private Sub ToolStripButton2_Click(sender As Object, e As EventArgs)
    End Sub

    Private Sub PenulisToolStripMenuItem_Click(sender As Object, e As EventArgs)
    End Sub

    Private Sub PenerbitToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub AnggotaToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub KoleksiToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub RakToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub ToolStripButton3_Click(sender As Object, e As EventArgs) Handles ToolStripButton3.Click
        FormPenjualan.Close()

        FormPenjualan.ShowDialog()
    End Sub

    Private Sub ToolStripButton4_Click(sender As Object, e As EventArgs) Handles ToolStripButton4.Click
        FormPenjualanResep.Close()

        FormPenjualanResep.ShowDialog()
    End Sub

    Private Sub AnggotaToolStripMenuItem1_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub KoleksiToolStripMenuItem1_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub PengunjungToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub PeminjamanToolStripMenuItem1_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub BukuDipinjamToolStripMenuItem_Click(sender As Object, e As EventArgs)

    End Sub

    Sub Statusmenu(status As Boolean)
        '  ToolStripButton6.Enabled = status
        ToolStripButton3.Enabled = status
        ToolStripButton4.Enabled = status
        ToolStripButton1.Enabled = status
        LogoutToolStripMenuItem.Enabled = status
    End Sub

    Private Sub FormUtama_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Call Statusmenu(False)
        LoginToolStripMenuItem.Enabled = True
    End Sub

    Private Sub LogoutToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles LogoutToolStripMenuItem.Click
        Call Statusmenu(False)
        LoginToolStripMenuItem.Enabled = True
    End Sub

    Private Sub ResetPasswordToolStripMenuItem_Click(sender As Object, e As EventArgs)
        FormResetPassword.Close()
        FormResetPassword.ShowDialog()
    End Sub

    Private Sub ToolStripButton1_Click_1(sender As Object, e As EventArgs)
        FormGembong.Close()

        FormGembong.ShowDialog()
    End Sub

    Private Sub ToolStrip1_ItemClicked(sender As Object, e As ToolStripItemClickedEventArgs) Handles ToolStrip1.ItemClicked

    End Sub

    Private Sub ToolStripButton1_Click_2(sender As Object, e As EventArgs) Handles ToolStripButton1.Click
        formcetak.Close()

        formcetak.ShowDialog()
    End Sub
End Class
