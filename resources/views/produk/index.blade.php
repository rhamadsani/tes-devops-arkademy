<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produk</title>
    <style>
    .container{
        margin-right: auto;
        margin-left: auto;
        display: table;
    }
    .styled-table {
        border-collapse: collapse;
        margin-top: 40px;
        margin-bottom: 20px;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgb(0 0 0 / 15%);
    }
    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }
    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }
    .custom-button{
        border: solid 2px #757575;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
    }
    </style>
</head>
<body class="antialiased">
    <div class="container">
    <table class="styled-table">
            <thead>
                <th>Nama Baran</th>
                <th>Keterangan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Action</th>
            </thead>
            <tbody id="table-body">
                @foreach($produk as $data)
                <tr>
                    <td>{{$data->nama_produk ?? ''}}</td>
                    <td>{{$data->keterangan ?? ''}}</td>
                    <td>{{$data->harga ?? ''}}</td>
                    <td>{{$data->jumlah ?? ''}}</td>
                    <td>
                        <a class="custom-button" onclick="editProduk({{$data->id ?? 0}},`{{$data->nama_produk ?? ''}}`, `{{$data->keterangan ?? ''}}`,{{$data->harga ?? 0}},{{$data->jumlah ?? 0}})">Edit</a>
                        <a class="custom-button" onclick="deleteProduk({{$data->id ?? 0}})">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <a class="custom-button" onclick="addProduk()">Tambah Produk</a>
        </div>
    </div>
</body>
<script src="sweetalert.js"></script>
<script src="jquery.js"></script>
<script>
    async function addProduk()
    {
        const { value: formValues } = await Swal.fire({
        title: 'Tambah Produk',
        html:
            '<input id="swal-input1" type="text" class="swal2-input">' +
            '<input id="swal-input2" type="text" class="swal2-input">'+
            '<input id="swal-input3" type="number" class="swal2-input">'+
            '<input id="swal-input4" type="number" class="swal2-input">',
        focusConfirm: false,
        preConfirm: () => {
            return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value,
            document.getElementById('swal-input3').value,
            document.getElementById('swal-input4').value,
            ]
        }
        })

        if (formValues) {
            $.ajax({
                type:'POST',
                url:'/produk',
                data:{
                    _token:'{{csrf_token()}}',
                    nama_produk:formValues[0],
                    keterangan:formValues[1],
                    harga:formValues[2],
                    jumlah:formValues[3]
                },
                success:function(result){
                    let html = '';
                    html+='<tr><td>'+result.nama_produk+'</td>';
                    html+='<td>'+result.keterangan+'</td>';
                    html+='<td>'+result.harga+'</td>';
                    html+='<td>'+result.jumlah+'</td>';
                    html+='<td><a class="custom-button" onclick="editProduk({{$data->id ?? 0}},`{{$data->nama_produk ?? ''}}`, `{{$data->keterangan ?? ''}}`,{{$data->harga ?? 0}},{{$data->jumlah ?? 0}})">Edit</a>';
                    html+='<a class="custom-button" onclick="deleteProduk({{$data->id ?? 0}})">Delete</a></td></tr>';
                    $("#table-body").prepend(html)
                }
            })
        }
    }

    async function editProduk(id,nama, keterangan, harga, jumlah)
    {
        const { value: formValues } = await Swal.fire({
        title: 'Tambah Produk',
        html:
            '<input id="edit-input1" type="text" class="swal2-input" value="'+nama+'">' +
            '<input id="edit-input2" type="text" class="swal2-input" value="'+keterangan+'">'+
            '<input id="edit-input3" type="number" class="swal2-input" value="'+jumlah+'">'+
            '<input id="edit-input4" type="number" class="swal2-input" value="'+harga+'">',
        focusConfirm: false,
        preConfirm: () => {
            return [
            document.getElementById('edit-input1').value,
            document.getElementById('edit-input2').value,
            document.getElementById('edit-input3').value,
            document.getElementById('edit-input4').value,
            ]
        }
        })

        if (formValues) {
            $.ajax({
                type:'POST',
                url:'/produk/'+id,
                data:{
                    _token:'{{csrf_token()}}',
                    _method:'PUT',
                    nama_produk:formValues[0],
                    keterangan:formValues[1],
                    harga:formValues[2],
                    jumlah:formValues[3]
                },
            })
        }
    }

    function deleteProduk(id)
    {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:'POST',
                url:'/produk/'+id,
                data:{
                    _token:'{{csrf_token()}}',
                    _method:'DELETE',
                },
            })
        }
        })
    }
</script>
</html>