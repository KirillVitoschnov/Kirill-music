@extends('layouts.app')

@section('content')
    <div class="main-wrapper">
        <nav class="sidebar">
            <div class="url-items-wrapper">
                <a href="">
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.8318 15.6H8.51817V10.2H5.48176V15.6H0.168091V4.37625L6.99997 0.400024L13.8318 4.34913V15.6Z"
                            fill="white"/>
                    </svg>
                    <span>Главная</span>
                </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path opacity="0.6" fill-rule="evenodd" clip-rule="evenodd"
                              d="M11.7202 11.2774L14.9888 15.1128L14.4219 15.6L11.1444 11.7646C10.0165 12.6208 8.74692 13.0489 7.33557 13.0489C6.4793 13.0489 5.65995 12.8821 4.87753 12.5485C4.09511 12.2148 3.42192 11.766 2.85795 11.2021C2.29398 10.6382 1.84518 9.96496 1.51157 9.18251C1.17795 8.40007 1.01113 7.58073 1.01111 6.72448C1.01109 5.86824 1.1779 5.04889 1.51157 4.26645C1.84523 3.48401 2.29402 2.81081 2.85795 2.24686C3.42187 1.68292 4.09507 1.23412 4.87753 0.900483C5.66 0.566844 6.47934 0.400024 7.33557 0.400024C8.19179 0.400024 9.01113 0.566844 9.7936 0.900483C10.5761 1.23412 11.2493 1.68292 11.8132 2.24686C12.3771 2.81081 12.8259 3.48401 13.1596 4.26645C13.4932 5.04889 13.66 5.86824 13.66 6.72448C13.66 7.60435 13.4888 8.43698 13.1463 9.22238C12.8038 10.0078 12.3284 10.6928 11.7202 11.2774L11.7202 11.2774ZM7.33564 12.3049C8.34541 12.3049 9.27843 12.0554 10.1347 11.5564C10.991 11.0573 11.6686 10.3797 12.1676 9.52348C12.6666 8.66723 12.9161 7.73421 12.9161 6.72441C12.9161 5.71461 12.6666 4.78159 12.1676 3.92535C11.6685 3.0691 10.9909 2.39149 10.1347 1.89251C9.27848 1.39352 8.34546 1.14403 7.33564 1.14403C6.32581 1.14403 5.39279 1.39352 4.53657 1.89251C3.68035 2.39149 3.00273 3.0691 2.50373 3.92535C2.00472 4.78159 1.75523 5.71461 1.75526 6.72441C1.75528 7.73421 2.00477 8.66723 2.50373 9.52348C3.00269 10.3797 3.6803 11.0573 4.53657 11.5564C5.39284 12.0554 6.32586 12.3049 7.33564 12.3049Z"
                              fill="white"/>
                    </svg>
                    <span>Поиск</span> </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path opacity="0.6"
                              d="M9.17679 0.659882L15.6 15.0852L14.8548 15.4186L8.43153 0.993306L9.17679 0.659882ZM0.400024 15.4088V0.581421H1.22379V15.4088H0.400024ZM5.34249 15.4088V0.581421H6.16626V15.4088H5.34249Z"
                              fill="white"/>
                    </svg>
                    <span>
                           Библиотека
                    </span>
                </a>
            </div>
        </nav>
        <div class="content">

        </div>
        <div class="player-wrapper"></div>
    </div>
@endsection
