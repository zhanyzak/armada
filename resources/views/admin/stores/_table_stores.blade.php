<tr>
    <td></td>
    <td>{{ $store->title }}</td>
    <td>
        {!! $store->user->company ?? '<span class="text-danger font-weight-bold">Нет данных !!!</span>' !!}
        <hr class="my-1">
        {!! $store->user->name ?? '<span class="text-danger font-weight-bold">Нет данных !!!</span>' !!}
    </td>

    <td>
        @if($store->phones != null)
            @foreach($store->phones as $phone)
                <a href="tel:{{ $phone }}">{{ $phone }}</a><br>
            @endforeach
        @endif
    </td>
    <td>{{ $store->whatsapp }}</td>
    <td>
        @if($store->status == 1)
            <div class="products__status products__status--active">Активный</div>
        @else
            <span class="products__status products__status--hot">Не активный</span>
        @endif

        @if($store->hot == true and $store->hot_end_date > now())
            <div class="products__status products__status--hot">Горячий</div>
        @endif

        @if($store->is_delivery == 1)
            <div class="products__status products__status--five">Доставка</div>
        @endif
    </td>
    <td style="white-space: nowrap;">
        <b>Создания:</b><br>
        <span>{{ $store->created_at }}</span><br>
        <b>Обновления:</b><br>
        <span>{{ $store->updated_at }}</span>
    </td>
    <td>
        <a href="{{ route('admin.products.index',['store'=>$store->id]) }}" class="font-weight-bold">{{ $store->products_count }}</a>
    </td>
    <td class="text-center">
        <button class="products-table__edit" data-toggle="modal" data-target="#quick-edit" data-item-id="{{ $store->id }}">
            <input type="hidden" name="edit-action" value="{{ route('admin.stores.edit',$store->id) }}">
            <input type="hidden" name="edit-link" value="{{ route('admin.storeUpdate',$store->id) }}">
            <input type="hidden" name="edit-product-isActive" value="{{ $store->status  }}">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="30" height="30" rx="3" fill="#169BD5"/>
                <path d="M21.4541 14.8847C21.1036 14.8847 20.8195 15.1689 20.8195 15.5194V21.8658C20.8195 22.2163 20.5353 22.5004 20.1848 22.5004H8.76134C8.41083 22.5004 8.12669 22.2163 8.12669 21.8658V9.17296C8.12669 8.82245 8.41083 8.53831 8.76134 8.53831H16.377C16.7275 8.53831 17.0117 8.25417 17.0117 7.90366C17.0117 7.55314 16.7275 7.26904 16.377 7.26904H8.76134C7.70984 7.26904 6.85742 8.12146 6.85742 9.17296V21.8658C6.85742 22.9173 7.70984 23.7697 8.76134 23.7697H20.1849C21.2364 23.7697 22.0888 22.9173 22.0888 21.8658V15.5193C22.0888 15.1689 21.8046 14.8847 21.4541 14.8847Z" fill="white"/>
                <path d="M23.9161 6.71167C23.4604 6.25592 22.8424 5.99994 22.1979 6.00001C21.5531 5.99815 20.9344 6.25458 20.48 6.71208L12.1204 15.0709C12.0511 15.1408 11.9988 15.2257 11.9675 15.319L10.6982 19.1269C10.5875 19.4594 10.7672 19.8188 11.0998 19.9295C11.1643 19.951 11.2319 19.962 11.2999 19.9621C11.368 19.962 11.4357 19.951 11.5004 19.9297L15.3082 18.6604C15.4018 18.6292 15.4867 18.5766 15.5564 18.5069L23.9159 10.1474C24.8647 9.19871 24.8648 7.66047 23.9161 6.71167ZM23.0185 9.25062L14.7682 17.501L12.3032 18.3241L13.1238 15.8623L21.3773 7.61198C21.831 7.15913 22.566 7.15988 23.0189 7.61362C23.2352 7.83038 23.3571 8.12381 23.358 8.43004C23.3588 8.7379 23.2365 9.0333 23.0185 9.25062Z" fill="white"/>
            </svg>
        </button>
        @if($store->slug != null)
            <a href="{{ route('shop',['slug'=>$store->slug]) }}" class="products-table__view" target="_blank">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="30" height="30" rx="3" fill="#FFA900"/>
                    <path d="M14.9999 17.9549C16.6319 17.9549 17.9549 16.6319 17.9549 14.9999C17.9549 13.3679 16.6319 12.0449 14.9999 12.0449C13.3679 12.0449 12.0449 13.3679 12.0449 14.9999C12.0449 16.6319 13.3679 17.9549 14.9999 17.9549Z" fill="white"/>
                    <path d="M26.8498 14.6262C26.6334 14.3972 21.485 9 14.9982 9C8.51215 9 3.36448 14.3972 3.14863 14.6262C2.95176 14.8365 2.95176 15.1644 3.14863 15.3737C3.36534 15.6027 8.51315 21.0023 14.9982 21.0023C21.485 21.0023 26.6349 15.6027 26.8498 15.3737C27.0481 15.1644 27.0481 14.8348 26.8498 14.6262ZM14.9996 19.5687C12.4815 19.5687 10.4329 17.5197 10.4329 14.9995C10.4329 12.4814 12.4815 10.4312 14.9996 10.4312C17.5176 10.4312 19.5691 12.4807 19.5691 14.9995C19.5686 17.5183 17.5176 19.5687 14.9996 19.5687ZM11.3784 10.687C10.1442 11.7256 9.34131 13.263 9.34131 14.9995C9.34131 16.7354 10.1442 18.2729 11.3784 19.3133C7.96352 18.2151 5.2819 15.9042 4.32341 14.9995C5.28205 14.0958 7.96424 11.7847 11.3784 10.687ZM18.6226 19.3116C19.8559 18.2723 20.6598 16.7345 20.6598 14.9995C20.6598 13.2646 19.8566 11.7279 18.6216 10.6886C22.0363 11.7868 24.7159 14.0948 25.675 14.9995C24.7158 15.9033 22.0362 18.2118 18.6226 19.3116Z" fill="white"/>
                </svg>
            </a>
        @else
            <br><span class="font-weight-bold text-danger">Нет slug</span><br>
        @endif
        <button class="products-table__delete" data-toggle="modal" data-target="#confirm-delete-modal" data-item-id="{{ $store->id }}">
            <input type="hidden" name="delete-action" value="{{ route('admin.stores.destroy',$store->id) }}">
            <input type="hidden" name="delete-product-name" value="{{ $store->title }}">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="30" height="30" rx="3" fill="#E0001A"/>
                <path d="M21.9641 6.85707H18.4284V6.21422C18.4284 5.15081 17.5632 4.28564 16.4998 4.28564H13.9284C12.865 4.28564 11.9998 5.15081 11.9998 6.21422V6.85707H8.46408C7.5779 6.85707 6.85693 7.57804 6.85693 8.46422V10.7142C6.85693 11.0692 7.14477 11.3571 7.49979 11.3571H7.85111L8.4065 23.0202C8.45556 24.0502 9.30172 24.8571 10.3329 24.8571H20.0953C21.1265 24.8571 21.9726 24.0502 22.0217 23.0202L22.577 11.3571H22.9284C23.2834 11.3571 23.5712 11.0692 23.5712 10.7142V8.46422C23.5712 7.57804 22.8503 6.85707 21.9641 6.85707ZM13.2855 6.21422C13.2855 5.85976 13.5739 5.57136 13.9284 5.57136H16.4998C16.8542 5.57136 17.1426 5.85976 17.1426 6.21422V6.85707H13.2855V6.21422ZM8.14265 8.46422C8.14265 8.28699 8.28685 8.14279 8.46408 8.14279H21.9641C22.1413 8.14279 22.2855 8.28699 22.2855 8.46422V10.0714C22.0874 10.0714 8.96362 10.0714 8.14265 10.0714V8.46422ZM20.7374 22.9591C20.721 23.3024 20.439 23.5714 20.0953 23.5714H10.3329C9.98913 23.5714 9.70708 23.3024 9.69077 22.9591L9.13827 11.3571H21.2899L20.7374 22.9591Z" fill="white"/>
                <path d="M15.2141 22.2859C15.5692 22.2859 15.857 21.9981 15.857 21.6431V13.2859C15.857 12.9309 15.5692 12.6431 15.2141 12.6431C14.8591 12.6431 14.5713 12.9309 14.5713 13.2859V21.6431C14.5713 21.9981 14.8591 22.2859 15.2141 22.2859Z" fill="white"/>
                <path d="M18.4285 22.2859C18.7835 22.2859 19.0714 21.9981 19.0714 21.6431V13.2859C19.0714 12.9309 18.7835 12.6431 18.4285 12.6431C18.0735 12.6431 17.7856 12.9309 17.7856 13.2859V21.6431C17.7856 21.9981 18.0734 22.2859 18.4285 22.2859Z" fill="white"/>
                <path d="M11.9998 22.2859C12.3548 22.2859 12.6426 21.9981 12.6426 21.6431V13.2859C12.6426 12.9309 12.3548 12.6431 11.9998 12.6431C11.6448 12.6431 11.3569 12.9309 11.3569 13.2859V21.6431C11.3569 21.9981 11.6447 22.2859 11.9998 22.2859Z" fill="white"/>
            </svg>
        </button>
    </td>
</tr>