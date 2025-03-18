<?php
namespace App\Controllers;
class Page extends BaseController
{
    public function about()    
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
            ]);
    }
    public function contact()
    {
        return view('contact', [
            'title' => 'Halaman Contact',
            'content' => 'Ini adalah halaman contact yang menjelaskan tentang isi halaman ini.'
        ]);
    }
    public function faqs()
    {
        return view('faqs', [
            'title' => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ yang menjelaskan tentang isi halaman ini.'
        ]);
    }
    public function tos()
    {
        echo "ini halaman term of services";
    }
    public function home()
    {
        return view('home', [
            'title' => 'Halaman Home',
            'content' => 'Ini adalah halaman home yang menjelaskan tentang isi halaman ini.'
        ]);
    }

}
