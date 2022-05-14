<html>

<body>


    <?php


// echo "<pre>";
// print_r($irt->data_);


    // Function to calculate square of value - mean
    function sd_square($x, $mean)
    {
        return pow($x - $mean, 2);
    }

    // Function to calculate standard deviation (uses sd_square)    
    function sd($array)
    {
        // square root of sum of squares devided by N-1
        return sqrt(array_sum(array_map("sd_square", $array, array_fill(0, count($array), (array_sum($array) / count($array))))) / (count($array) - 1));
    }
    ?>



    <!-- HIDDEN -->

    <?php
    foreach ($irt->data_array_rata_rata as $d) {
    ?>
        <!-- <td><?php echo (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100 ?></td> -->
    <?php

        $data_array_bobot[$d->soal_id] = array(
            'soal_id' => $d->soal_id,
            'bobot' => (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100,
        );
    }
    ?>

    <?php


    // echo "<pre>";
    // print_r($data_array_bobot);
    ?>








    <table border="1">

        <thead>
            <td>Email</td>

            <?php
            foreach ($irt->data_array_rata_rata as $d) {
            ?>

                <td><?php echo $d->soal_id ?></td>

            <?php
            }
            ?>
            <td>Benar</td>
            <td>Salah</td>
            <td>Kosong</td>
            <td>Waktu</td>
            <td>Point </td>

        </thead>
        <tbody>
            <?php
            $rata_rata = 0;


            foreach ($irt->data_ as $d) {
            ?>

                <tr>
                    <td style="color:#2f6b10"><?php echo $d->email ?></td>

                    <?php


                    //    echo "<pre>";
                    //    print_r($d);


                    foreach ($d->data_array_jawaban as $j) {


                    //    echo "<pre>";
                    //    print_r($j);

                        if ($j->hasil_pilihan == 1) {
                            $color = 'style="color:blue"';
                            $hasil_benar[$d->email][]  = $j->hasil_pilihan;
                        }

                        else if ($j->hasil_pilihan == 2) {
                            $color = 'style="color:red"';
                            $hasil_salah[$d->email][]  = $j->hasil_pilihan;
                        }
                        
                        
                        else if ($j->hasil_pilihan == 0) {
                            $color = 'style="color:black"';
                            $hasil_kosong[$d->email][]  = $j->hasil_pilihan;
                        }
                    ?>


                        <td <?php echo $color; ?>><?php echo $j->hasil_pilihan ?></td>

                    <?php
                    }
                    ?>
                   <td>
                       <?php  
                       error_reporting(0);
                        if($hasil_benar){
                            echo count($hasil_benar[$d->email]);
                            // echo "<pre>";
                            // print_r($hasil_benar[$d->email]);
                        }else{
                            echo 0;
                        }
                      
                       
                       
                       ?> 
                
                
                
                    </td>
                    <td><?php echo count($hasil_salah[$d->email]);?> </td>
                    <td><?php echo count($hasil_kosong[$d->email]);?> </td>

                    <td><?php echo $d->waktu;?> </td>

                    <td>
                        <?php
                        $hitung_skor_kali = 0;
                        foreach ($d->data_array_jawaban as $j) {

                            if ($data_array_bobot[$j->soal_id]['soal_id'] == $j->soal_id) {

                                if ($j->hasil_pilihan == 1) {


                                    $hitung_skor_kali += $data_array_bobot[$j->soal_id]['bobot'] * 1;
                                }
                            }
                        ?>


                        <?php


                        }

                        $rata_rata += $hitung_skor_kali;

                        echo $hitung_skor_kali;


                        $arr[] = $hitung_skor_kali;
                        ?>


                    </td>


                    




                </tr>

            <?php
            }


            ?>





        </tbody>
        <tfoot>
            <tr>
                <td style="background-color: #72889b;">Jumlah Benar</td>

                <?php
                foreach ($irt->data_array_rata_rata as $d) {
                ?>

                    <td><?php echo $d->jumlah ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Tingkat Kesulitan</td>

                <?php
                foreach ($irt->data_array_rata_rata as $d) {
                ?>

                    <td><?php echo 1 - ($d->jumlah / $irt->jumlah_peserta) ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>


            <tr>
                <td style="background-color: #72889b;">Pembeda</td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Bobot</td>
                <?php
                foreach ($irt->data_array_rata_rata as $d) {
                ?>
                    <td><?php echo (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100 ?></td>
                <?php

                    // $data_array_bobot[$d->soal_id] = array(
                    //     'soal_id'=>$d->soal_id,
                    //     'bobot'=> (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100,
                    // );


                }
                ?>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="background-color: #72889b;">Rata - Rata</td>
                <td><?php echo $rata_rata / $irt->jumlah_peserta; ?></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Deviasi</td>
                <td>

                    <?php echo sd($arr); ?>
                </td>

            </tr>
        </tfoot>


    </table>

    <br>

    <table border="1">
        <thead>
            <td>Z - Score</td>

            <td>CEEB</td>
        </thead>
        <tbody>
            <?php
            foreach ($arr as $a) {
                $z_score = ($a - ($rata_rata / $irt->jumlah_peserta)) / sd($arr);
            ?>
                <tr>
                    <td><?php echo $z_score;; ?></td>

                    <td><?php echo  500 + (100 * $z_score);; ?></td>

                    <?php $z_score_hasil[] =  500 + (100 * $z_score);; ?>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>


    <?php
    echo "<pre>";
    print_r($arr);
    // echo json_encode($z_score_hasil);
    ?>




</body>

</html>