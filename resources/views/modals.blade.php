


{{-- Add to MH Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Add To MH    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalmhadd" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/add_mh') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Add To MH Form</h4>
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            
		          </div>
		          <!--=====================================
		            MODAL BODY
		          ======================================-->
		          <div class="modal-body">
		            <div class="box-body">
		            	@if ($errors->any())
						    <div class="alert alert-danger">
						        <ul>
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  {{-- <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp; --}}
		                  <div class="col-xs-12 col-sm-12 col-md-12">
		                  	<strong>Head-Particulars : </strong>
		                  	<input type="text" class="form-control input-lg" name="mhin_head" placeholder="Head-Particulars" required>	
		                  </div>
		                  
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  {{-- <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp; --}}
		                  <div class="col-xs-12 col-sm-12 col-md-12">
		                  	<strong>Amount :</strong>
		                  	<input type="number" class="form-control input-lg" name="mhin_amount" placeholder="Amount"  required>
		              	</div>
		                </div>
		              </div>
		              <!-- TAKING purpose -->
		              
		              <div class="form-group">
		                <div class="input-group">                 
		                  {{-- <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp; --}}
		                  <div class="col-xs-12 col-sm-12 col-md-12">
		                  	<strong>Note :</strong>
		                  	<textarea type="text" class="form-control input-lg" name="mhin_note" placeholder="Note" required></textarea>
		              	  </div>
		                </div>
		              </div>
		             
		              <!-- SELECTING ROLE FOR NEW USER -->             
		              <div class="form-group">
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
		                  	<strong>Disburse : (M/D/Y)</strong>
		                  	<input type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required>
		                  	{{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
		                  </div>
		                </div>
		              </div>
		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Add to MH Table-------------------------------------------------------------------------------------------- --}}


         {{-- Payment of occ Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Payment of occ    =
      ===========================-->


      @php

      	$getOCC = DB::table('occs')->get();

      @endphp

    <!-- Modal -->
    <div id="modaloccpayment" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/occ_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">OCC Payment Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">
                  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            		{{-- <input type="hidden" name="id" value="{{ $getName->id }}"> --}}
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>OCC Head & ID :</strong>
                        <input type="text" class="form-control input-lg" list="occ_select" name="occview_name" placeholder="Head & ID"  required>
                        <datalist id="occ_select">
                        @foreach($getOCC as $occ)
                          <option>{{ $occ->occ_name }}:{{ $occ->occ_id }}</option>
                        @endforeach
                      </datalist>  
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio :</strong>
                        <input type="text" class="form-control input-lg" name="occview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit :</strong>
                        <input type="number" class="form-control input-lg" name="occview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit :</strong>
                        <input type="number" class="form-control input-lg" name="occview_debit" placeholder="Credit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>

                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note :</strong>
                        <textarea type="text" class="form-control input-lg" name="occview_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse : (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg" id="occd_date" name="occview_disburse" placeholder="Date" required>
                        {{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Make</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- Payment of OCC Table-------------------------------------------------------------------------------------------- --}}




         {{-- Payment of supply Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Payment of supply    =
      ===========================-->


      @php

        $getSupply = DB::table('supplies')->get();

      @endphp

    <!-- Modal -->
    <div id="modalsupplypayment" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/supplies_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">Supply Payment Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">
                  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                {{-- <input type="hidden" name="id" value="{{ $getName->id }}"> --}}
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Sypply Head & ID :</strong>
                        <input type="text" class="form-control input-lg" list="supplies_select" name="suppliesview_particulars" placeholder="Head & ID"  required>
                        <datalist id="supplies_select">
                        @foreach($getSupply as $supply)
                          <option>{{ $supply->supplies_name }}:{{ $supply->supplies_id }}</option>
                        @endforeach
                      </datalist>  
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Name :</strong>
                        <input type="text" class="form-control input-lg" name="suppliesview_name" placeholder="Name" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio :</strong>
                        <input type="text" class="form-control input-lg" name="suppliesview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit :</strong>
                        <input type="number" class="form-control input-lg" name="suppliesview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit :</strong>
                        <input type="number" class="form-control input-lg" name="suppliesview_debit" placeholder="Credit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>

                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note :</strong>
                        <textarea type="text" class="form-control input-lg" name="suppliesview_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse : (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg" id="suppliesd_date" name="suppliesview_disburse" placeholder="Date" required>
                        {{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Make</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- Payment of project Table-------------------------------------------------------------------------------------------- --}}



        {{-- Payment of civil Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Payment of civil    =
      ===========================-->


      @php

        $getCivil = DB::table('civils')->get();

      @endphp

    <!-- Modal -->
    <div id="modalcivilpayment" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/civil_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">Civil Payment Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">
                  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                {{-- <input type="hidden" name="id" value="{{ $getName->id }}"> --}}
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Civil Head & ID :</strong>
                        <input type="text" class="form-control input-lg" list="civil_select" name="civilview_name" placeholder="Head & ID"  required>
                        <datalist id="civil_select">
                        @foreach($getCivil as $civil)
                          <option>{{ $civil->civil_name }}:{{ $civil->civil_id }}</option>
                        @endforeach
                      </datalist>  
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio :</strong>
                        <input type="text" class="form-control input-lg" name="civilview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit :</strong>
                        <input type="number" class="form-control input-lg" name="civilview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit :</strong>
                        <input type="number" class="form-control input-lg" name="civilview_debit" placeholder="Credit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>

                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note :</strong>
                        <textarea type="text" class="form-control input-lg" name="civilview_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse : (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg" id="civild_date" name="civilview_disburse" placeholder="Date" required>
                        {{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Make</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- Payment of Civil Table-------------------------------------------------------------------------------------------- --}}


                 {{-- Payment of ICT Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Payment of ICT    =
      ===========================-->


      @php

        $getICT = DB::table('icts')->get();

      @endphp

    <!-- Modal -->
    <div id="modalictpayment" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/ict_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">ICT Payment Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">
                  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                {{-- <input type="hidden" name="id" value="{{ $getName->id }}"> --}}
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>ICT Head & ID :</strong>
                        <input type="text" class="form-control input-lg" list="ict_select" name="ictview_name" placeholder="Head & ID"  required>
                        <datalist id="ict_select">
                        @foreach($getICT as $ict)
                          <option>{{ $ict->ict_name }}:{{ $ict->ict_id }}</option>
                        @endforeach
                      </datalist>  
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio :</strong>
                        <input type="text" class="form-control input-lg" name="ictview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit :</strong>
                        <input type="number" class="form-control input-lg" name="ictview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit :</strong>
                        <input type="number" class="form-control input-lg" name="ictview_debit" placeholder="Credit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>

                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note :</strong>
                        <textarea type="text" class="form-control input-lg" name="ictview_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse : (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg" id="ictd_date" name="ictview_disburse" placeholder="Date" required>
                        {{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Make</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- Payment of ICT Table-------------------------------------------------------------------------------------------- --}}


        {{-- Payment of Others Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Payment of Others    =
      ===========================-->


      @php

        $getOthers = DB::table('others')->get();

      @endphp

    <!-- Modal -->
    <div id="modalotherspayment" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/others_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">Others Payment Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">
                  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                {{-- <input type="hidden" name="id" value="{{ $getName->id }}"> --}}
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Others Head & ID :</strong>
                        <input type="text" class="form-control input-lg" list="others_select" name="othersview_name" placeholder="Head & ID"  required>
                        <datalist id="others_select">
                        @foreach($getOthers as $others)
                          <option>{{ $others->others_name }}:{{ $others->others_id }}</option>
                        @endforeach
                      </datalist>  
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio :</strong>
                        <input type="text" class="form-control input-lg" name="othersview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit :</strong>
                        <input type="number" class="form-control input-lg" name="othersview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit :</strong>
                        <input type="number" class="form-control input-lg" name="othersview_debit" placeholder="Credit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>

                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note :</strong>
                        <textarea type="text" class="form-control input-lg" name="othersview_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse : (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg" id="othersd_date" name="othersview_disburse" placeholder="Date" required>
                        {{-- <textarea type="date" class="form-control input-lg" id="d_date" name="mhin_disburse" placeholder="Date" required></textarea> --}}
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Make</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- Payment of Others Table-------------------------------------------------------------------------------------------- --}}