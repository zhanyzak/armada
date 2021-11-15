<div class="modal fade pay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Оплатить тариф</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @php

        @endphp
        <div class="modal-body">
            <div class="panel orders vendor__panel pt-4 pb-3 p-xxl-3 pt-xxl-5 pr-0">
                <!-- ======= Pricing Section ======= -->
                <div id="pricing" class="pricing">
                    <div class="row">
                        @foreach($tarifs as $tarif)
                        <div class="col-md-4">
                            <div class="box">
                                <h5>{{$tarif->title ?? ''}}</h5>
                                <h6>{{ $tarif->placement_price ?? '' }} тг<span> / в месяц</span></h6>
                                <div class="btn-wrap">
                                    <a href="{{ route('seller.payStore', ['tarif' => $tarif->id, 'store' => $store->id]) }}" class="btn-buy">Купить</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div><!-- End Pricing Section -->
            </div>
        </div>
      </div>
    </div>
  </div>


