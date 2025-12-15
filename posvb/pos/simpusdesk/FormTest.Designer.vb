<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class FormTest
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Dim DataGridViewCellStyle6 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle5 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle4 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle3 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle2 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle1 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Me.Label7 = New System.Windows.Forms.Label()
        Me.combotipepenjualan = New System.Windows.Forms.ComboBox()
        Me.kategori = New System.Windows.Forms.TextBox()
        Me.Label6 = New System.Windows.Forms.Label()
        Me.TextDiskon = New System.Windows.Forms.TextBox()
        Me.Button4 = New System.Windows.Forms.Button()
        Me.tgltransaksi = New System.Windows.Forms.DateTimePicker()
        Me.cbjenisharga = New System.Windows.Forms.ComboBox()
        Me.Label8 = New System.Windows.Forms.Label()
        Me.txtnonota = New System.Windows.Forms.TextBox()
        Me.Label13 = New System.Windows.Forms.Label()
        Me.Label12 = New System.Windows.Forms.Label()
        Me.Label15 = New System.Windows.Forms.Label()
        Me.txtnamacustomer = New System.Windows.Forms.TextBox()
        Me.txtkdcustomer = New System.Windows.Forms.TextBox()
        Me.Label11 = New System.Windows.Forms.Label()
        Me.btnclear = New System.Windows.Forms.Button()
        Me.btncetak = New System.Windows.Forms.Button()
        Me.CheckBox1 = New System.Windows.Forms.CheckBox()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.txtkembali = New System.Windows.Forms.TextBox()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.txtbayar = New System.Windows.Forms.TextBox()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.txtjmltotal = New System.Windows.Forms.TextBox()
        Me.btnsimpan = New System.Windows.Forms.Button()
        Me.txtdisplayjmltotal = New System.Windows.Forms.TextBox()
        Me.PrintDocument1 = New System.Drawing.Printing.PrintDocument()
        Me.TableLayoutPanel1 = New System.Windows.Forms.TableLayoutPanel()
        Me.txtqty = New System.Windows.Forms.TextBox()
        Me.txtkdbarang = New System.Windows.Forms.TextBox()
        Me.Label14 = New System.Windows.Forms.Label()
        Me.txtkasir = New System.Windows.Forms.TextBox()
        Me.Label9 = New System.Windows.Forms.Label()
        Me.Label5 = New System.Windows.Forms.Label()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.Label10 = New System.Windows.Forms.Label()
        Me.btnpending = New System.Windows.Forms.Button()
        Me.btnambilpending = New System.Windows.Forms.Button()
        Me.TableLayoutPanel2 = New System.Windows.Forms.TableLayoutPanel()
        Me.FlowLayoutPanel1 = New System.Windows.Forms.FlowLayoutPanel()
        Me.golongan = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.total = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.diskonamount = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.diskonpersen = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.jumlah = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.qty = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.harga = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.namabarang = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.Kode = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.DataGridView1 = New System.Windows.Forms.DataGridView()
        Me.TableLayoutPanel1.SuspendLayout()
        Me.TableLayoutPanel2.SuspendLayout()
        Me.FlowLayoutPanel1.SuspendLayout()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(143, 82)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(82, 13)
        Me.Label7.TabIndex = 91
        Me.Label7.Text = "K : Belum Bayar"
        '
        'combotipepenjualan
        '
        Me.combotipepenjualan.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.combotipepenjualan.FormattingEnabled = True
        Me.combotipepenjualan.Items.AddRange(New Object() {"T", "K"})
        Me.combotipepenjualan.Location = New System.Drawing.Point(101, 79)
        Me.combotipepenjualan.Name = "combotipepenjualan"
        Me.combotipepenjualan.Size = New System.Drawing.Size(36, 21)
        Me.combotipepenjualan.TabIndex = 90
        '
        'kategori
        '
        Me.kategori.Location = New System.Drawing.Point(217, 31)
        Me.kategori.Name = "kategori"
        Me.kategori.ReadOnly = True
        Me.kategori.Size = New System.Drawing.Size(198, 20)
        Me.kategori.TabIndex = 88
        Me.kategori.Text = "umum"
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(837, 31)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(50, 16)
        Me.Label6.TabIndex = 87
        Me.Label6.Text = "Diskon"
        '
        'TextDiskon
        '
        Me.TextDiskon.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.TextDiskon.Location = New System.Drawing.Point(900, 34)
        Me.TextDiskon.Name = "TextDiskon"
        Me.TextDiskon.ReadOnly = True
        Me.TextDiskon.Size = New System.Drawing.Size(222, 22)
        Me.TextDiskon.TabIndex = 86
        Me.TextDiskon.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Button4
        '
        Me.Button4.Location = New System.Drawing.Point(185, 5)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(27, 23)
        Me.Button4.TabIndex = 82
        Me.Button4.Text = "..."
        Me.Button4.UseVisualStyleBackColor = True
        '
        'tgltransaksi
        '
        Me.tgltransaksi.CustomFormat = "dd/mm/yyyy"
        Me.tgltransaksi.Format = System.Windows.Forms.DateTimePickerFormat.[Short]
        Me.tgltransaksi.Location = New System.Drawing.Point(101, 32)
        Me.tgltransaksi.Margin = New System.Windows.Forms.Padding(2)
        Me.tgltransaksi.Name = "tgltransaksi"
        Me.tgltransaksi.Size = New System.Drawing.Size(111, 20)
        Me.tgltransaksi.TabIndex = 81
        '
        'cbjenisharga
        '
        Me.cbjenisharga.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbjenisharga.FormattingEnabled = True
        Me.cbjenisharga.Items.AddRange(New Object() {"Harga HV", "Harga Grosir", "Harga Resep"})
        Me.cbjenisharga.Location = New System.Drawing.Point(101, 55)
        Me.cbjenisharga.Name = "cbjenisharga"
        Me.cbjenisharga.Size = New System.Drawing.Size(110, 21)
        Me.cbjenisharga.TabIndex = 79
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(12, 82)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(78, 13)
        Me.Label8.TabIndex = 89
        Me.Label8.Text = "Tipe Penjualan"
        '
        'txtnonota
        '
        Me.txtnonota.Location = New System.Drawing.Point(273, 56)
        Me.txtnonota.Name = "txtnonota"
        Me.txtnonota.ReadOnly = True
        Me.txtnonota.Size = New System.Drawing.Size(143, 20)
        Me.txtnonota.TabIndex = 78
        '
        'Label13
        '
        Me.Label13.AutoSize = True
        Me.Label13.Location = New System.Drawing.Point(12, 58)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(63, 13)
        Me.Label13.TabIndex = 73
        Me.Label13.Text = "Jenis Harga"
        '
        'Label12
        '
        Me.Label12.AutoSize = True
        Me.Label12.Location = New System.Drawing.Point(12, 33)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(75, 13)
        Me.Label12.TabIndex = 72
        Me.Label12.Text = "Tgl. Penjualan"
        '
        'Label15
        '
        Me.Label15.AutoSize = True
        Me.Label15.Location = New System.Drawing.Point(217, 58)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(50, 13)
        Me.Label15.TabIndex = 77
        Me.Label15.Text = "No. Nota"
        '
        'txtnamacustomer
        '
        Me.txtnamacustomer.Location = New System.Drawing.Point(218, 5)
        Me.txtnamacustomer.Name = "txtnamacustomer"
        Me.txtnamacustomer.ReadOnly = True
        Me.txtnamacustomer.Size = New System.Drawing.Size(198, 20)
        Me.txtnamacustomer.TabIndex = 76
        Me.txtnamacustomer.Text = "Pelanggan Umum"
        '
        'txtkdcustomer
        '
        Me.txtkdcustomer.Enabled = False
        Me.txtkdcustomer.Location = New System.Drawing.Point(101, 7)
        Me.txtkdcustomer.Name = "txtkdcustomer"
        Me.txtkdcustomer.Size = New System.Drawing.Size(78, 20)
        Me.txtkdcustomer.TabIndex = 74
        Me.txtkdcustomer.Text = "C0001"
        '
        'Label11
        '
        Me.Label11.AutoSize = True
        Me.Label11.Location = New System.Drawing.Point(12, 7)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(58, 13)
        Me.Label11.TabIndex = 71
        Me.Label11.Text = "Pelanggan"
        '
        'btnclear
        '
        Me.btnclear.Location = New System.Drawing.Point(183, 3)
        Me.btnclear.Name = "btnclear"
        Me.btnclear.Size = New System.Drawing.Size(75, 30)
        Me.btnclear.TabIndex = 69
        Me.btnclear.Text = "Clear"
        Me.btnclear.UseVisualStyleBackColor = True
        '
        'btncetak
        '
        Me.btncetak.Location = New System.Drawing.Point(93, 3)
        Me.btncetak.Name = "btncetak"
        Me.btncetak.Size = New System.Drawing.Size(75, 30)
        Me.btncetak.TabIndex = 70
        Me.btncetak.Text = "Cetak Nota"
        Me.btncetak.UseVisualStyleBackColor = True
        '
        'CheckBox1
        '
        Me.CheckBox1.AutoSize = True
        Me.CheckBox1.Location = New System.Drawing.Point(900, 120)
        Me.CheckBox1.Name = "CheckBox1"
        Me.CheckBox1.Size = New System.Drawing.Size(138, 17)
        Me.CheckBox1.TabIndex = 67
        Me.CheckBox1.Text = "Pembayaran Non Tunai"
        Me.CheckBox1.UseVisualStyleBackColor = True
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(837, 85)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(57, 16)
        Me.Label3.TabIndex = 66
        Me.Label3.Text = "Kembali"
        '
        'txtkembali
        '
        Me.txtkembali.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtkembali.Location = New System.Drawing.Point(900, 88)
        Me.txtkembali.Name = "txtkembali"
        Me.txtkembali.ReadOnly = True
        Me.txtkembali.Size = New System.Drawing.Size(222, 22)
        Me.txtkembali.TabIndex = 65
        Me.txtkembali.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(837, 61)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(44, 16)
        Me.Label2.TabIndex = 64
        Me.Label2.Text = "Bayar"
        '
        'txtbayar
        '
        Me.txtbayar.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtbayar.Location = New System.Drawing.Point(900, 64)
        Me.txtbayar.Name = "txtbayar"
        Me.txtbayar.Size = New System.Drawing.Size(222, 22)
        Me.txtbayar.TabIndex = 63
        Me.txtbayar.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(837, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(51, 16)
        Me.Label1.TabIndex = 62
        Me.Label1.Text = "Jumlah"
        '
        'txtjmltotal
        '
        Me.txtjmltotal.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtjmltotal.Location = New System.Drawing.Point(900, 3)
        Me.txtjmltotal.Name = "txtjmltotal"
        Me.txtjmltotal.ReadOnly = True
        Me.txtjmltotal.Size = New System.Drawing.Size(222, 22)
        Me.txtjmltotal.TabIndex = 61
        Me.txtjmltotal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'btnsimpan
        '
        Me.btnsimpan.Location = New System.Drawing.Point(3, 3)
        Me.btnsimpan.Name = "btnsimpan"
        Me.btnsimpan.Size = New System.Drawing.Size(75, 30)
        Me.btnsimpan.TabIndex = 68
        Me.btnsimpan.Text = "Simpan"
        Me.btnsimpan.UseVisualStyleBackColor = True
        '
        'txtdisplayjmltotal
        '
        Me.txtdisplayjmltotal.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.txtdisplayjmltotal.BackColor = System.Drawing.Color.FromArgb(CType(CType(128, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer))
        Me.txtdisplayjmltotal.Font = New System.Drawing.Font("Microsoft Sans Serif", 48.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtdisplayjmltotal.Location = New System.Drawing.Point(547, 5)
        Me.txtdisplayjmltotal.Multiline = True
        Me.txtdisplayjmltotal.Name = "txtdisplayjmltotal"
        Me.txtdisplayjmltotal.Size = New System.Drawing.Size(635, 81)
        Me.txtdisplayjmltotal.TabIndex = 58
        Me.txtdisplayjmltotal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'TableLayoutPanel1
        '
        Me.TableLayoutPanel1.Anchor = CType(((System.Windows.Forms.AnchorStyles.Bottom Or System.Windows.Forms.AnchorStyles.Left) _
            Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.TableLayoutPanel1.ColumnCount = 6
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle())
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle())
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle())
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 100.0!))
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle())
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle())
        Me.TableLayoutPanel1.Controls.Add(Me.Label10, 2, 4)
        Me.TableLayoutPanel1.Controls.Add(Me.txtqty, 0, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.Label9, 1, 4)
        Me.TableLayoutPanel1.Controls.Add(Me.Label5, 2, 3)
        Me.TableLayoutPanel1.Controls.Add(Me.Label4, 1, 3)
        Me.TableLayoutPanel1.Controls.Add(Me.txtkdbarang, 1, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.btnpending, 2, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.TextDiskon, 5, 1)
        Me.TableLayoutPanel1.Controls.Add(Me.Label1, 4, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.txtjmltotal, 5, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.Label6, 4, 1)
        Me.TableLayoutPanel1.Controls.Add(Me.Label2, 4, 2)
        Me.TableLayoutPanel1.Controls.Add(Me.txtbayar, 5, 2)
        Me.TableLayoutPanel1.Controls.Add(Me.Label3, 4, 3)
        Me.TableLayoutPanel1.Controls.Add(Me.Label14, 1, 5)
        Me.TableLayoutPanel1.Controls.Add(Me.txtkembali, 5, 3)
        Me.TableLayoutPanel1.Controls.Add(Me.CheckBox1, 5, 4)
        Me.TableLayoutPanel1.Controls.Add(Me.TableLayoutPanel2, 5, 5)
        Me.TableLayoutPanel1.Controls.Add(Me.txtkasir, 2, 5)
        Me.TableLayoutPanel1.Controls.Add(Me.btnambilpending, 3, 0)
        Me.TableLayoutPanel1.Location = New System.Drawing.Point(16, 397)
        Me.TableLayoutPanel1.Name = "TableLayoutPanel1"
        Me.TableLayoutPanel1.RowCount = 6
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 100.0!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 30.0!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 24.0!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 32.0!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 25.0!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 122.0!))
        Me.TableLayoutPanel1.Size = New System.Drawing.Size(1166, 264)
        Me.TableLayoutPanel1.TabIndex = 92
        '
        'txtqty
        '
        Me.txtqty.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtqty.Location = New System.Drawing.Point(3, 3)
        Me.txtqty.Name = "txtqty"
        Me.txtqty.Size = New System.Drawing.Size(53, 31)
        Me.txtqty.TabIndex = 59
        Me.txtqty.Text = "1"
        Me.txtqty.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        '
        'txtkdbarang
        '
        Me.txtkdbarang.BackColor = System.Drawing.Color.Aqua
        Me.txtkdbarang.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtkdbarang.Location = New System.Drawing.Point(62, 3)
        Me.txtkdbarang.Name = "txtkdbarang"
        Me.txtkdbarang.Size = New System.Drawing.Size(233, 31)
        Me.txtkdbarang.TabIndex = 60
        '
        'Label14
        '
        Me.Label14.AutoSize = True
        Me.Label14.Location = New System.Drawing.Point(62, 142)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(30, 13)
        Me.Label14.TabIndex = 75
        Me.Label14.Text = "Kasir"
        '
        'txtkasir
        '
        Me.txtkasir.Location = New System.Drawing.Point(301, 145)
        Me.txtkasir.Name = "txtkasir"
        Me.txtkasir.ReadOnly = True
        Me.txtkasir.Size = New System.Drawing.Size(143, 20)
        Me.txtkasir.TabIndex = 80
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(62, 117)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(101, 13)
        Me.Label9.TabIndex = 21
        Me.Label9.Text = "Tab : Pindah Kursor"
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(301, 85)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(82, 13)
        Me.Label5.TabIndex = 17
        Me.Label5.Text = "F5 : Hapus Item"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(62, 85)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(83, 13)
        Me.Label4.TabIndex = 16
        Me.Label4.Text = "F2 : Cari Barang"
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(301, 117)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(81, 13)
        Me.Label10.TabIndex = 22
        Me.Label10.Text = "+ : Pembayaran"
        '
        'btnpending
        '
        Me.btnpending.Location = New System.Drawing.Point(301, 3)
        Me.btnpending.Name = "btnpending"
        Me.btnpending.Size = New System.Drawing.Size(108, 25)
        Me.btnpending.TabIndex = 84
        Me.btnpending.Text = "Pending Transaksi"
        Me.btnpending.UseVisualStyleBackColor = True
        '
        'btnambilpending
        '
        Me.btnambilpending.Location = New System.Drawing.Point(450, 3)
        Me.btnambilpending.Name = "btnambilpending"
        Me.btnambilpending.Size = New System.Drawing.Size(101, 25)
        Me.btnambilpending.TabIndex = 85
        Me.btnambilpending.Text = "Ambil Pending"
        Me.btnambilpending.UseVisualStyleBackColor = True
        '
        'TableLayoutPanel2
        '
        Me.TableLayoutPanel2.ColumnCount = 3
        Me.TableLayoutPanel2.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 50.0!))
        Me.TableLayoutPanel2.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 50.0!))
        Me.TableLayoutPanel2.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Absolute, 83.0!))
        Me.TableLayoutPanel2.Controls.Add(Me.btnsimpan, 0, 0)
        Me.TableLayoutPanel2.Controls.Add(Me.btncetak, 1, 0)
        Me.TableLayoutPanel2.Controls.Add(Me.btnclear, 2, 0)
        Me.TableLayoutPanel2.Location = New System.Drawing.Point(900, 145)
        Me.TableLayoutPanel2.Name = "TableLayoutPanel2"
        Me.TableLayoutPanel2.RowCount = 2
        Me.TableLayoutPanel2.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 50.0!))
        Me.TableLayoutPanel2.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 50.0!))
        Me.TableLayoutPanel2.Size = New System.Drawing.Size(263, 100)
        Me.TableLayoutPanel2.TabIndex = 88
        '
        'FlowLayoutPanel1
        '
        Me.FlowLayoutPanel1.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
            Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.FlowLayoutPanel1.Controls.Add(Me.DataGridView1)
        Me.FlowLayoutPanel1.Location = New System.Drawing.Point(16, 106)
        Me.FlowLayoutPanel1.Name = "FlowLayoutPanel1"
        Me.FlowLayoutPanel1.Size = New System.Drawing.Size(1166, 285)
        Me.FlowLayoutPanel1.TabIndex = 93
        '
        'golongan
        '
        Me.golongan.HeaderText = "Golongan"
        Me.golongan.Name = "golongan"
        '
        'total
        '
        DataGridViewCellStyle6.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.total.DefaultCellStyle = DataGridViewCellStyle6
        Me.total.HeaderText = "Total"
        Me.total.Name = "total"
        Me.total.ReadOnly = True
        Me.total.Width = 150
        '
        'diskonamount
        '
        DataGridViewCellStyle5.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        DataGridViewCellStyle5.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.diskonamount.DefaultCellStyle = DataGridViewCellStyle5
        Me.diskonamount.HeaderText = "Disk Rp"
        Me.diskonamount.Name = "diskonamount"
        '
        'diskonpersen
        '
        DataGridViewCellStyle4.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        DataGridViewCellStyle4.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.diskonpersen.DefaultCellStyle = DataGridViewCellStyle4
        Me.diskonpersen.HeaderText = "Disk %"
        Me.diskonpersen.Name = "diskonpersen"
        '
        'jumlah
        '
        DataGridViewCellStyle3.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.jumlah.DefaultCellStyle = DataGridViewCellStyle3
        Me.jumlah.HeaderText = "Jumlah"
        Me.jumlah.Name = "jumlah"
        Me.jumlah.ReadOnly = True
        '
        'qty
        '
        DataGridViewCellStyle2.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter
        DataGridViewCellStyle2.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.qty.DefaultCellStyle = DataGridViewCellStyle2
        Me.qty.HeaderText = "QTY"
        Me.qty.Name = "qty"
        Me.qty.Width = 50
        '
        'harga
        '
        DataGridViewCellStyle1.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.harga.DefaultCellStyle = DataGridViewCellStyle1
        Me.harga.HeaderText = "harga"
        Me.harga.Name = "harga"
        Me.harga.ReadOnly = True
        '
        'namabarang
        '
        Me.namabarang.HeaderText = "Nama Barang"
        Me.namabarang.Name = "namabarang"
        Me.namabarang.ReadOnly = True
        Me.namabarang.Resizable = System.Windows.Forms.DataGridViewTriState.[False]
        Me.namabarang.Width = 300
        '
        'Kode
        '
        Me.Kode.HeaderText = "Kode"
        Me.Kode.Name = "Kode"
        Me.Kode.ReadOnly = True
        '
        'DataGridView1
        '
        Me.DataGridView1.AllowUserToAddRows = False
        Me.DataGridView1.AllowUserToResizeColumns = False
        Me.DataGridView1.AllowUserToResizeRows = False
        Me.DataGridView1.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
            Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.DataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.DataGridView1.Columns.AddRange(New System.Windows.Forms.DataGridViewColumn() {Me.Kode, Me.namabarang, Me.harga, Me.qty, Me.jumlah, Me.diskonpersen, Me.diskonamount, Me.total, Me.golongan})
        Me.DataGridView1.EditMode = System.Windows.Forms.DataGridViewEditMode.EditOnEnter
        Me.DataGridView1.Location = New System.Drawing.Point(3, 3)
        Me.DataGridView1.Name = "DataGridView1"
        Me.DataGridView1.Size = New System.Drawing.Size(1074, 252)
        Me.DataGridView1.TabIndex = 58
        '
        'FormTest
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(1194, 673)
        Me.Controls.Add(Me.FlowLayoutPanel1)
        Me.Controls.Add(Me.TableLayoutPanel1)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.combotipepenjualan)
        Me.Controls.Add(Me.kategori)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.tgltransaksi)
        Me.Controls.Add(Me.cbjenisharga)
        Me.Controls.Add(Me.Label8)
        Me.Controls.Add(Me.txtnonota)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.Label12)
        Me.Controls.Add(Me.Label15)
        Me.Controls.Add(Me.txtnamacustomer)
        Me.Controls.Add(Me.txtkdcustomer)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.txtdisplayjmltotal)
        Me.Name = "FormTest"
        Me.Text = "FormTest"
        Me.WindowState = System.Windows.Forms.FormWindowState.Maximized
        Me.TableLayoutPanel1.ResumeLayout(False)
        Me.TableLayoutPanel1.PerformLayout()
        Me.TableLayoutPanel2.ResumeLayout(False)
        Me.FlowLayoutPanel1.ResumeLayout(False)
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents Label7 As Label
    Friend WithEvents combotipepenjualan As ComboBox
    Friend WithEvents kategori As TextBox
    Friend WithEvents Label6 As Label
    Friend WithEvents TextDiskon As TextBox
    Friend WithEvents Button4 As Button
    Friend WithEvents tgltransaksi As DateTimePicker
    Friend WithEvents cbjenisharga As ComboBox
    Friend WithEvents Label8 As Label
    Friend WithEvents txtnonota As TextBox
    Friend WithEvents Label13 As Label
    Friend WithEvents Label12 As Label
    Friend WithEvents Label15 As Label
    Friend WithEvents txtnamacustomer As TextBox
    Friend WithEvents txtkdcustomer As TextBox
    Friend WithEvents Label11 As Label
    Friend WithEvents btnclear As Button
    Friend WithEvents btncetak As Button
    Friend WithEvents CheckBox1 As CheckBox
    Friend WithEvents Label3 As Label
    Friend WithEvents txtkembali As TextBox
    Friend WithEvents Label2 As Label
    Friend WithEvents txtbayar As TextBox
    Friend WithEvents Label1 As Label
    Friend WithEvents txtjmltotal As TextBox
    Friend WithEvents btnsimpan As Button
    Friend WithEvents txtdisplayjmltotal As TextBox
    Friend WithEvents PrintDocument1 As Printing.PrintDocument
    Friend WithEvents TableLayoutPanel1 As TableLayoutPanel
    Friend WithEvents txtqty As TextBox
    Friend WithEvents txtkdbarang As TextBox
    Friend WithEvents btnpending As Button
    Friend WithEvents btnambilpending As Button
    Friend WithEvents Label14 As Label
    Friend WithEvents txtkasir As TextBox
    Friend WithEvents Label9 As Label
    Friend WithEvents Label5 As Label
    Friend WithEvents Label4 As Label
    Friend WithEvents Label10 As Label
    Friend WithEvents TableLayoutPanel2 As TableLayoutPanel
    Friend WithEvents FlowLayoutPanel1 As FlowLayoutPanel
    Friend WithEvents DataGridView1 As DataGridView
    Friend WithEvents Kode As DataGridViewTextBoxColumn
    Friend WithEvents namabarang As DataGridViewTextBoxColumn
    Friend WithEvents harga As DataGridViewTextBoxColumn
    Friend WithEvents qty As DataGridViewTextBoxColumn
    Friend WithEvents jumlah As DataGridViewTextBoxColumn
    Friend WithEvents diskonpersen As DataGridViewTextBoxColumn
    Friend WithEvents diskonamount As DataGridViewTextBoxColumn
    Friend WithEvents total As DataGridViewTextBoxColumn
    Friend WithEvents golongan As DataGridViewTextBoxColumn
End Class
