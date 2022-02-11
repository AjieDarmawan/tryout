<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Karyawan</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/karyawan/simpan')?>" method="post">
                        <div class="card-body">

                        <div class="form-group row">
                                <label class="col-2 col-form-label">Nik Kantor</label>
                                <div class="col-10">
                                    <input class="form-control" name="nik_kantor" type="text" id="nik_kantor" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nik KTP</label>
                                <div class="col-10">
                                    <input class="form-control" name="nik_ktp" type="number" id="nik_ktp" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Karyawan</label>
                                <div class="col-10">
                                    <input class="form-control" type="text"  name="nama_karyawan" id="nama_karyawan"  />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Penempatan</label>
                                <div class="col-10">
                                <select class="form-control" id="kt_select2_3" name="ktr_id">
                                        <?php 
                                               foreach($kantor as $d){
                                                           ?>
                                                    <option value=<?php echo $d->ktr_id?>><?php echo $d->kantor_nama?></option>
                                                <?php  
                                                 }
                                               ?>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-search-input" class="col-2 col-form-label">Divisi</label>
                                <div class="col-10">
                                <select class="form-control" id="kt_select2_2" name="div_id">
                                        <?php 
                                               foreach($divisi as $d){
                                                           ?>
                                                    <option value=<?php echo $d->div_id?>><?php echo $d->divisi_nama?></option>
                                                <?php  
                                                 }
                                               ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                                <div class="col-10">
                                <select class="form-control" id="kt_select2_1" name="jbt_id">
                                        <?php 
                                                
                                               foreach($jabatan as $j){
                                                           ?>
                                                    <option value=<?php echo $j->jbt_id?>><?php echo $j->jabatan_nama?></option>
                                                <?php  
                                                 }
                                               ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-url-input" class="col-2 col-form-label">No Wa</label>
                                <div class="col-10">
                                    <input class="form-control" type="number"name="no_wa" id="no_wa"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-2 col-form-label">No HP</label>
                                <div class="col-10">
                                    <input class="form-control" type="number" name="no_hp" id="no_hp" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-tel-input" class="col-2 col-form-label">Alamat</label>
                                <div class="col-10">
                                    <textarea class="form-control" type="text" name="alamat" id="alamat"> </textarea>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-password-input" class="col-2 col-form-label">Tempat Lahir</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-number-input" class="col-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-10">
                                    <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" />
                                </div>
                            </div>

                           


                            <div class="form-group row">
                                <label for="example-number-input" class="col-2 col-form-label">Status Perkawinan</label>
                                <div class="col-10">
                                    <select class="form-control"name="status_perkawinan" id="status_perkawinan">
                                        <option value="">--Pilih--</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-2 col-form-label">Jenis
                                    Kelamin</label>
                                <div class="col-10">
                                    <select class="form-control"name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Agama</label>
                                <div class="col-10">
                                    <select class="form-control" name="agama" id="agama">
                                        <option value="">--Pilih--</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Kristen Katolik">Kristen Katolik</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Hindu">Hindu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-week-input" class="col-2 col-form-label">Pendidikan</label>
                                <div class="col-10">
                                    <select class="form-control" name="pendidikan" id="pendidikan">
                                        <option value="">--Pilih--</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-time-input" class="col-2 col-form-label">Sekolah Terakhir</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="sekolah_terakhir" id="sekolah_terakhir" />
                                </div>
                            </div>


                        </div>

                </div>
                <!--end::Card-->

            </div>


            <div class="col-md-6">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">

                    <!--begin::Form-->

                    <div class="card-body">
                        <div class="form-group mb-8">

                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-2 col-form-label">Tahun Masuk</label>
                            <div class="col-10">
                                <input class="form-control" type="number"  name="tahun_masuk" id="tahun_masuk"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-2 col-form-label">Tahun Keluar</label>
                            <div class="col-10">
                                <input class="form-control" type="text"  name="tahun_keluar" id="tahun_keluar"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-time-input" class="col-2 col-form-label">Jurusan</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="jurusan" id="jurusan"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-time-input" class="col-2 col-form-label">Nilai</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="nilai" id="nilai"  />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" type="email"
                                name="email" id="email"   />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-url-input" class="col-2 col-form-label">Nama Keluarga</label>
                            <div class="col-10">
                                <input class="form-control" type="text"
                                name="nama_keluarga" id="nama_keluarga"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-tel-input" class="col-2 col-form-label">Hubungan Keluarga</label>
                            <div class="col-10">
                                <input class="form-control" type="number" 
                                name="hubungan_keluarga" id="hubungan_keluarga"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-password-input" class="col-2 col-form-label">No Hp Keluarga</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="hunter2"
                                name="no_hp_keluarga" id="no_hp_keluarga"  />
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="example-number-input" class="col-2 col-form-label">Tanggal Join</label>
                                <div class="col-10">
                                    <input class="form-control" type="date" name="tanggal_join" id="tanggal_join" />
                                </div>
                            </div>


                            <div class="form-group row">
                            <label for="example-password-input" class="col-2 col-form-label">No KK</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="hunter2"
                                name="no_kk" id="no_kk"  />
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="example-password-input" class="col-2 col-form-label">No NPWP</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="hunter2"
                                name="no_npwp" id="no_npwp"  />
                            </div>
                        </div>
                       

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end::Card-->

            </div>



        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->