<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()>
Partial Class FormPenjualan
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()>
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
    <System.Diagnostics.DebuggerStepThrough()>
    Private Sub InitializeComponent()
        Dim DataGridViewCellStyle7 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle8 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle9 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle10 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle11 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Dim DataGridViewCellStyle12 As System.Windows.Forms.DataGridViewCellStyle = New System.Windows.Forms.DataGridViewCellStyle()
        Me.DataGridView1 = New System.Windows.Forms.DataGridView()
        Me.Kode = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.namabarang = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.harga = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.qty = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.Satuan = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.jumlah = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.diskonpersen = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.diskonamount = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.total = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.golongan = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.txtdisplayjmltotal = New System.Windows.Forms.TextBox()
        Me.txtqty = New System.Windows.Forms.TextBox()
        Me.txtkdbarang = New System.Windows.Forms.TextBox()
        Me.txtjmltotal = New System.Windows.Forms.TextBox()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.txtbayar = New System.Windows.Forms.TextBox()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.txtkembali = New System.Windows.Forms.TextBox()
        Me.CheckBox1 = New System.Windows.Forms.CheckBox()
        Me.btnsimpan = New System.Windows.Forms.Button()
        Me.btncetak = New System.Windows.Forms.Button()
        Me.btnclear = New System.Windows.Forms.Button()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.Label5 = New System.Windows.Forms.Label()
        Me.Label9 = New System.Windows.Forms.Label()
        Me.Label10 = New System.Windows.Forms.Label()
        Me.Label11 = New System.Windows.Forms.Label()
        Me.Label12 = New System.Windows.Forms.Label()
        Me.Label13 = New System.Windows.Forms.Label()
        Me.txtkdcustomer = New System.Windows.Forms.TextBox()
        Me.Label14 = New System.Windows.Forms.Label()
        Me.txtnamacustomer = New System.Windows.Forms.TextBox()
        Me.Label15 = New System.Windows.Forms.Label()
        Me.txtnonota = New System.Windows.Forms.TextBox()
        Me.cbjenisharga = New System.Windows.Forms.ComboBox()
        Me.txtkasir = New System.Windows.Forms.TextBox()
        Me.tgltransaksi = New System.Windows.Forms.DateTimePicker()
        Me.Button4 = New System.Windows.Forms.Button()
        Me.Panel1 = New System.Windows.Forms.Panel()
        Me.PrintDocument1 = New System.Drawing.Printing.PrintDocument()
        Me.btnpending = New System.Windows.Forms.Button()
        Me.btnambilpending = New System.Windows.Forms.Button()
        Me.TextDiskon = New System.Windows.Forms.TextBox()
        Me.Label6 = New System.Windows.Forms.Label()
        Me.kategori = New System.Windows.Forms.TextBox()
        Me.Label7 = New System.Windows.Forms.Label()
        Me.combotipepenjualan = New System.Windows.Forms.ComboBox()
        Me.Label8 = New System.Windows.Forms.Label()
        Me.Label16 = New System.Windows.Forms.Label()
        Me.TextGrandTotal = New System.Windows.Forms.TextBox()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'DataGridView1
        '
        Me.DataGridView1.AllowUserToAddRows = False
        Me.DataGridView1.AllowUserToResizeColumns = False
        Me.DataGridView1.AllowUserToResizeRows = False
        Me.DataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.DataGridView1.Columns.AddRange(New System.Windows.Forms.DataGridViewColumn() {Me.Kode, Me.namabarang, Me.harga, Me.qty, Me.Satuan, Me.jumlah, Me.diskonpersen, Me.diskonamount, Me.total, Me.golongan})
        Me.DataGridView1.EditMode = System.Windows.Forms.DataGridViewEditMode.EditOnEnter
        Me.DataGridView1.Location = New System.Drawing.Point(37, 117)
        Me.DataGridView1.Name = "DataGridView1"
        Me.DataGridView1.Size = New System.Drawing.Size(1119, 378)
        Me.DataGridView1.TabIndex = 0
        '
        'Kode
        '
        Me.Kode.HeaderText = "Kode"
        Me.Kode.Name = "Kode"
        Me.Kode.ReadOnly = True
        '
        'namabarang
        '
        Me.namabarang.HeaderText = "Nama Barang"
        Me.namabarang.Name = "namabarang"
        Me.namabarang.ReadOnly = True
        Me.namabarang.Resizable = System.Windows.Forms.DataGridViewTriState.[False]
        Me.namabarang.Width = 300
        '
        'harga
        '
        DataGridViewCellStyle7.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.harga.DefaultCellStyle = DataGridViewCellStyle7
        Me.harga.HeaderText = "harga"
        Me.harga.Name = "harga"
        Me.harga.ReadOnly = True
        '
        'qty
        '
        DataGridViewCellStyle8.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter
        DataGridViewCellStyle8.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.qty.DefaultCellStyle = DataGridViewCellStyle8
        Me.qty.HeaderText = "QTY"
        Me.qty.Name = "qty"
        Me.qty.Width = 50
        '
        'Satuan
        '
        Me.Satuan.HeaderText = "Satuan"
        Me.Satuan.Name = "Satuan"
        Me.Satuan.ReadOnly = True
        Me.Satuan.Width = 70
        '
        'jumlah
        '
        DataGridViewCellStyle9.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.jumlah.DefaultCellStyle = DataGridViewCellStyle9
        Me.jumlah.HeaderText = "Jumlah"
        Me.jumlah.Name = "jumlah"
        Me.jumlah.ReadOnly = True
        '
        'diskonpersen
        '
        DataGridViewCellStyle10.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        DataGridViewCellStyle10.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.diskonpersen.DefaultCellStyle = DataGridViewCellStyle10
        Me.diskonpersen.HeaderText = "Disk %"
        Me.diskonpersen.Name = "diskonpersen"
        '
        'diskonamount
        '
        DataGridViewCellStyle11.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        DataGridViewCellStyle11.BackColor = System.Drawing.Color.FromArgb(CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.diskonamount.DefaultCellStyle = DataGridViewCellStyle11
        Me.diskonamount.HeaderText = "Disk Rp"
        Me.diskonamount.Name = "diskonamount"
        '
        'total
        '
        DataGridViewCellStyle12.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight
        Me.total.DefaultCellStyle = DataGridViewCellStyle12
        Me.total.HeaderText = "Total"
        Me.total.Name = "total"
        Me.total.ReadOnly = True
        Me.total.Width = 150
        '
        'golongan
        '
        Me.golongan.HeaderText = "Golongan"
        Me.golongan.Name = "golongan"
        '
        'txtdisplayjmltotal
        '
        Me.txtdisplayjmltotal.BackColor = System.Drawing.Color.FromArgb(CType(CType(128, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(255, Byte), Integer))
        Me.txtdisplayjmltotal.Font = New System.Drawing.Font("Microsoft Sans Serif", 48.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtdisplayjmltotal.Location = New System.Drawing.Point(522, 12)
        Me.txtdisplayjmltotal.Multiline = True
        Me.txtdisplayjmltotal.Name = "txtdisplayjmltotal"
        Me.txtdisplayjmltotal.ReadOnly = True
        Me.txtdisplayjmltotal.Size = New System.Drawing.Size(635, 81)
        Me.txtdisplayjmltotal.TabIndex = 2
        Me.txtdisplayjmltotal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'txtqty
        '
        Me.txtqty.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtqty.Location = New System.Drawing.Point(35, 501)
        Me.txtqty.Name = "txtqty"
        Me.txtqty.Size = New System.Drawing.Size(53, 31)
        Me.txtqty.TabIndex = 3
        Me.txtqty.Text = "1"
        Me.txtqty.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        '
        'txtkdbarang
        '
        Me.txtkdbarang.BackColor = System.Drawing.Color.Aqua
        Me.txtkdbarang.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtkdbarang.Location = New System.Drawing.Point(94, 501)
        Me.txtkdbarang.Name = "txtkdbarang"
        Me.txtkdbarang.Size = New System.Drawing.Size(233, 31)
        Me.txtkdbarang.TabIndex = 4
        '
        'txtjmltotal
        '
        Me.txtjmltotal.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtjmltotal.Location = New System.Drawing.Point(934, 560)
        Me.txtjmltotal.Name = "txtjmltotal"
        Me.txtjmltotal.ReadOnly = True
        Me.txtjmltotal.Size = New System.Drawing.Size(222, 22)
        Me.txtjmltotal.TabIndex = 5
        Me.txtjmltotal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(854, 566)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(51, 16)
        Me.Label1.TabIndex = 6
        Me.Label1.Text = "Jumlah"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(855, 598)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(44, 16)
        Me.Label2.TabIndex = 8
        Me.Label2.Text = "Bayar"
        '
        'txtbayar
        '
        Me.txtbayar.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtbayar.Location = New System.Drawing.Point(935, 592)
        Me.txtbayar.Name = "txtbayar"
        Me.txtbayar.Size = New System.Drawing.Size(222, 22)
        Me.txtbayar.TabIndex = 7
        Me.txtbayar.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(855, 627)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(57, 16)
        Me.Label3.TabIndex = 10
        Me.Label3.Text = "Kembali"
        '
        'txtkembali
        '
        Me.txtkembali.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtkembali.Location = New System.Drawing.Point(935, 624)
        Me.txtkembali.Name = "txtkembali"
        Me.txtkembali.ReadOnly = True
        Me.txtkembali.Size = New System.Drawing.Size(222, 22)
        Me.txtkembali.TabIndex = 9
        Me.txtkembali.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'CheckBox1
        '
        Me.CheckBox1.AutoSize = True
        Me.CheckBox1.Location = New System.Drawing.Point(934, 658)
        Me.CheckBox1.Name = "CheckBox1"
        Me.CheckBox1.Size = New System.Drawing.Size(138, 17)
        Me.CheckBox1.TabIndex = 12
        Me.CheckBox1.Text = "Pembayaran Non Tunai"
        Me.CheckBox1.UseVisualStyleBackColor = True
        '
        'btnsimpan
        '
        Me.btnsimpan.Location = New System.Drawing.Point(919, 685)
        Me.btnsimpan.Name = "btnsimpan"
        Me.btnsimpan.Size = New System.Drawing.Size(75, 30)
        Me.btnsimpan.TabIndex = 13
        Me.btnsimpan.Text = "Simpan"
        Me.btnsimpan.UseVisualStyleBackColor = True
        '
        'btncetak
        '
        Me.btncetak.Location = New System.Drawing.Point(1000, 685)
        Me.btncetak.Name = "btncetak"
        Me.btncetak.Size = New System.Drawing.Size(75, 30)
        Me.btncetak.TabIndex = 15
        Me.btncetak.Text = "Cetak Nota"
        Me.btncetak.UseVisualStyleBackColor = True
        '
        'btnclear
        '
        Me.btnclear.Location = New System.Drawing.Point(1081, 685)
        Me.btnclear.Name = "btnclear"
        Me.btnclear.Size = New System.Drawing.Size(75, 30)
        Me.btnclear.TabIndex = 14
        Me.btnclear.Text = "Clear"
        Me.btnclear.UseVisualStyleBackColor = True
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(12, 11)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(83, 13)
        Me.Label4.TabIndex = 16
        Me.Label4.Text = "F2 : Cari Barang"
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(120, 11)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(82, 13)
        Me.Label5.TabIndex = 17
        Me.Label5.Text = "F5 : Hapus Item"
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(12, 30)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(101, 13)
        Me.Label9.TabIndex = 21
        Me.Label9.Text = "Tab : Pindah Kursor"
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(119, 30)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(81, 13)
        Me.Label10.TabIndex = 22
        Me.Label10.Text = "+ : Pembayaran"
        '
        'Label11
        '
        Me.Label11.AutoSize = True
        Me.Label11.Location = New System.Drawing.Point(37, 18)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(58, 13)
        Me.Label11.TabIndex = 23
        Me.Label11.Text = "Pelanggan"
        '
        'Label12
        '
        Me.Label12.AutoSize = True
        Me.Label12.Location = New System.Drawing.Point(37, 44)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(75, 13)
        Me.Label12.TabIndex = 24
        Me.Label12.Text = "Tgl. Penjualan"
        '
        'Label13
        '
        Me.Label13.AutoSize = True
        Me.Label13.Location = New System.Drawing.Point(37, 69)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(63, 13)
        Me.Label13.TabIndex = 25
        Me.Label13.Text = "Jenis Harga"
        '
        'txtkdcustomer
        '
        Me.txtkdcustomer.Enabled = False
        Me.txtkdcustomer.Location = New System.Drawing.Point(126, 18)
        Me.txtkdcustomer.Name = "txtkdcustomer"
        Me.txtkdcustomer.Size = New System.Drawing.Size(78, 20)
        Me.txtkdcustomer.TabIndex = 26
        Me.txtkdcustomer.Text = "C0001"
        '
        'Label14
        '
        Me.Label14.AutoSize = True
        Me.Label14.Location = New System.Drawing.Point(38, 606)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(30, 13)
        Me.Label14.TabIndex = 29
        Me.Label14.Text = "Kasir"
        '
        'txtnamacustomer
        '
        Me.txtnamacustomer.Location = New System.Drawing.Point(243, 16)
        Me.txtnamacustomer.Name = "txtnamacustomer"
        Me.txtnamacustomer.ReadOnly = True
        Me.txtnamacustomer.Size = New System.Drawing.Size(198, 20)
        Me.txtnamacustomer.TabIndex = 30
        Me.txtnamacustomer.Text = "Pelanggan Umum"
        '
        'Label15
        '
        Me.Label15.AutoSize = True
        Me.Label15.Location = New System.Drawing.Point(242, 69)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(50, 13)
        Me.Label15.TabIndex = 32
        Me.Label15.Text = "No. Nota"
        '
        'txtnonota
        '
        Me.txtnonota.Location = New System.Drawing.Point(298, 67)
        Me.txtnonota.Name = "txtnonota"
        Me.txtnonota.ReadOnly = True
        Me.txtnonota.Size = New System.Drawing.Size(143, 20)
        Me.txtnonota.TabIndex = 33
        '
        'cbjenisharga
        '
        Me.cbjenisharga.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbjenisharga.FormattingEnabled = True
        Me.cbjenisharga.Items.AddRange(New Object() {"Harga HV", "Harga Grosir", "Harga Resep"})
        Me.cbjenisharga.Location = New System.Drawing.Point(126, 66)
        Me.cbjenisharga.Name = "cbjenisharga"
        Me.cbjenisharga.Size = New System.Drawing.Size(110, 21)
        Me.cbjenisharga.TabIndex = 34
        '
        'txtkasir
        '
        Me.txtkasir.Location = New System.Drawing.Point(94, 603)
        Me.txtkasir.Name = "txtkasir"
        Me.txtkasir.ReadOnly = True
        Me.txtkasir.Size = New System.Drawing.Size(143, 20)
        Me.txtkasir.TabIndex = 35
        '
        'tgltransaksi
        '
        Me.tgltransaksi.CustomFormat = "dd/mm/yyyy"
        Me.tgltransaksi.Format = System.Windows.Forms.DateTimePickerFormat.[Short]
        Me.tgltransaksi.Location = New System.Drawing.Point(126, 43)
        Me.tgltransaksi.Margin = New System.Windows.Forms.Padding(2)
        Me.tgltransaksi.Name = "tgltransaksi"
        Me.tgltransaksi.Size = New System.Drawing.Size(111, 20)
        Me.tgltransaksi.TabIndex = 44
        '
        'Button4
        '
        Me.Button4.Location = New System.Drawing.Point(210, 16)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(27, 23)
        Me.Button4.TabIndex = 45
        Me.Button4.Text = "..."
        Me.Button4.UseVisualStyleBackColor = True
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Panel1.Controls.Add(Me.Label10)
        Me.Panel1.Controls.Add(Me.Label4)
        Me.Panel1.Controls.Add(Me.Label5)
        Me.Panel1.Controls.Add(Me.Label9)
        Me.Panel1.Location = New System.Drawing.Point(35, 539)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(668, 58)
        Me.Panel1.TabIndex = 46
        '
        'PrintDocument1
        '
        '
        'btnpending
        '
        Me.btnpending.Location = New System.Drawing.Point(333, 501)
        Me.btnpending.Name = "btnpending"
        Me.btnpending.Size = New System.Drawing.Size(108, 30)
        Me.btnpending.TabIndex = 47
        Me.btnpending.Text = "Pending Transaksi"
        Me.btnpending.UseVisualStyleBackColor = True
        '
        'btnambilpending
        '
        Me.btnambilpending.Location = New System.Drawing.Point(448, 501)
        Me.btnambilpending.Name = "btnambilpending"
        Me.btnambilpending.Size = New System.Drawing.Size(101, 30)
        Me.btnambilpending.TabIndex = 48
        Me.btnambilpending.Text = "Ambil Pending"
        Me.btnambilpending.UseVisualStyleBackColor = True
        '
        'TextDiskon
        '
        Me.TextDiskon.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.TextDiskon.Location = New System.Drawing.Point(934, 532)
        Me.TextDiskon.Name = "TextDiskon"
        Me.TextDiskon.ReadOnly = True
        Me.TextDiskon.Size = New System.Drawing.Size(222, 22)
        Me.TextDiskon.TabIndex = 49
        Me.TextDiskon.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(854, 538)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(50, 16)
        Me.Label6.TabIndex = 50
        Me.Label6.Text = "Diskon"
        '
        'kategori
        '
        Me.kategori.Location = New System.Drawing.Point(242, 42)
        Me.kategori.Name = "kategori"
        Me.kategori.ReadOnly = True
        Me.kategori.Size = New System.Drawing.Size(198, 20)
        Me.kategori.TabIndex = 51
        Me.kategori.Text = "umum"
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(168, 93)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(82, 13)
        Me.Label7.TabIndex = 56
        Me.Label7.Text = "K : Belum Bayar"
        '
        'combotipepenjualan
        '
        Me.combotipepenjualan.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.combotipepenjualan.FormattingEnabled = True
        Me.combotipepenjualan.Items.AddRange(New Object() {"T", "K"})
        Me.combotipepenjualan.Location = New System.Drawing.Point(126, 90)
        Me.combotipepenjualan.Name = "combotipepenjualan"
        Me.combotipepenjualan.Size = New System.Drawing.Size(36, 21)
        Me.combotipepenjualan.TabIndex = 55
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(37, 93)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(78, 13)
        Me.Label8.TabIndex = 54
        Me.Label8.Text = "Tipe Penjualan"
        '
        'Label16
        '
        Me.Label16.AutoSize = True
        Me.Label16.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label16.Location = New System.Drawing.Point(855, 504)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(39, 16)
        Me.Label16.TabIndex = 57
        Me.Label16.Text = "Total"
        '
        'TextGrandTotal
        '
        Me.TextGrandTotal.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.TextGrandTotal.Location = New System.Drawing.Point(934, 501)
        Me.TextGrandTotal.Name = "TextGrandTotal"
        Me.TextGrandTotal.ReadOnly = True
        Me.TextGrandTotal.Size = New System.Drawing.Size(222, 22)
        Me.TextGrandTotal.TabIndex = 58
        Me.TextGrandTotal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right
        '
        'FormPenjualan
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(1176, 731)
        Me.Controls.Add(Me.TextGrandTotal)
        Me.Controls.Add(Me.Label16)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.combotipepenjualan)
        Me.Controls.Add(Me.Label8)
        Me.Controls.Add(Me.kategori)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.TextDiskon)
        Me.Controls.Add(Me.btnambilpending)
        Me.Controls.Add(Me.btnpending)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.tgltransaksi)
        Me.Controls.Add(Me.txtkasir)
        Me.Controls.Add(Me.cbjenisharga)
        Me.Controls.Add(Me.txtnonota)
        Me.Controls.Add(Me.Label15)
        Me.Controls.Add(Me.txtnamacustomer)
        Me.Controls.Add(Me.Label14)
        Me.Controls.Add(Me.txtkdcustomer)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.Label12)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.btnclear)
        Me.Controls.Add(Me.btncetak)
        Me.Controls.Add(Me.btnsimpan)
        Me.Controls.Add(Me.CheckBox1)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.txtkembali)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.txtbayar)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.txtjmltotal)
        Me.Controls.Add(Me.txtkdbarang)
        Me.Controls.Add(Me.txtqty)
        Me.Controls.Add(Me.txtdisplayjmltotal)
        Me.Controls.Add(Me.DataGridView1)
        Me.Name = "FormPenjualan"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
        Me.Text = "FormPenjualan"
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents DataGridView1 As DataGridView
    Friend WithEvents txtdisplayjmltotal As TextBox
    Friend WithEvents txtqty As TextBox
    Friend WithEvents txtkdbarang As TextBox
    Friend WithEvents txtjmltotal As TextBox
    Friend WithEvents Label1 As Label
    Friend WithEvents Label2 As Label
    Friend WithEvents txtbayar As TextBox
    Friend WithEvents Label3 As Label
    Friend WithEvents txtkembali As TextBox
    Friend WithEvents CheckBox1 As CheckBox
    Friend WithEvents btnsimpan As Button
    Friend WithEvents btncetak As Button
    Friend WithEvents btnclear As Button
    Friend WithEvents Label4 As Label
    Friend WithEvents Label5 As Label
    Friend WithEvents Label9 As Label
    Friend WithEvents Label10 As Label
    Friend WithEvents Label11 As Label
    Friend WithEvents Label12 As Label
    Friend WithEvents Label13 As Label
    Friend WithEvents txtkdcustomer As TextBox
    Friend WithEvents Label14 As Label
    Friend WithEvents txtnamacustomer As TextBox
    Friend WithEvents Label15 As Label
    Friend WithEvents txtnonota As TextBox
    Friend WithEvents cbjenisharga As ComboBox
    Friend WithEvents txtkasir As TextBox
    Friend WithEvents tgltransaksi As DateTimePicker
    Friend WithEvents Button4 As Button
    Friend WithEvents Panel1 As Panel
    Friend WithEvents PrintDocument1 As Printing.PrintDocument
    Friend WithEvents btnpending As Button
    Friend WithEvents btnambilpending As Button
    Friend WithEvents TextDiskon As TextBox
    Friend WithEvents Label6 As Label
    Friend WithEvents kategori As TextBox
    Friend WithEvents Label7 As Label
    Friend WithEvents combotipepenjualan As ComboBox
    Friend WithEvents Label8 As Label
    Friend WithEvents Kode As DataGridViewTextBoxColumn
    Friend WithEvents namabarang As DataGridViewTextBoxColumn
    Friend WithEvents harga As DataGridViewTextBoxColumn
    Friend WithEvents qty As DataGridViewTextBoxColumn
    Friend WithEvents Satuan As DataGridViewTextBoxColumn
    Friend WithEvents jumlah As DataGridViewTextBoxColumn
    Friend WithEvents diskonpersen As DataGridViewTextBoxColumn
    Friend WithEvents diskonamount As DataGridViewTextBoxColumn
    Friend WithEvents total As DataGridViewTextBoxColumn
    Friend WithEvents golongan As DataGridViewTextBoxColumn
    Friend WithEvents Label16 As Label
    Friend WithEvents TextGrandTotal As TextBox
End Class
