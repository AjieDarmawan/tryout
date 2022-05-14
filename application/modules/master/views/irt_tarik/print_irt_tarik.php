<?php 
$filename='file-name'.'.xls'; //save our workbook as this file name
// header('Content-Type: application/vnd.ms-excel'); //mime type
// header('Content-Disposition: attachment;filename=report_hasil_irt'.$nama_judul.'".xls'); //tell browser what's the file name
// header('Cache-Control: max-age=0'); //no c
?>

<h2><?php echo $data_api[0]['nama_judul']?></h2>
<table border="1">
    <thead>
        <tr>
            <th>Rangking</th>


            <th>Nama</th>
            <th>Email</th>
            <th>Asal Sekolah</th>
            <th>Skor</th>


        </tr>
    </thead>

    <tbody>
        <?php 
        $no=1;
            foreach($data_api as $a){
         ?>
            <tr>
                <td><?php echo $no++;?></td>
                <td><?php echo $a['nama']?></td>
                <td><?php echo $a['email']?></td>
                <td><?php echo $a['asal_sekolah']?></td>
                <td><?php echo $a['skor']?></td>
               
            </tr>
         
         <?php
            }
        ?>
        <tr>
            
        </tr>
    </tbody>
</table>