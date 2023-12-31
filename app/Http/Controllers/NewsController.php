<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu_Alan;
use App\Models\Logo;
use App\Models\Contact;
use App\Models\News;
use App\Models\IletisimForm;


class NewsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $news=News::all();
        return view('News.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('News.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $baslik = $request->baslik;
        $baslik = preg_replace('/[^A-Za-z0-9\-]+/', '_', $baslik);
        $validatedData = $request->validate([
            'baslik' => 'required|string|max:150',
            'kisa_aciklama' => 'required|string|max:150',
            'tarih' => 'required|date',
            'link' => $request->input('linkType') === 'harici' ? 'required' : '',
            'görsel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->input('linkType') === 'siteIci') {
            $validatedData = $request->validate([
                'content' => 'required|string',
                'meta_title'=>'required|string|max:250',
                'meta_description'=>'required|string|max:500',
                'meta_keywords'=>'required|string|max:250'
            ]);
        }
        try {
            if ($request->hasFile('görsel')) {
                $file = $request->file('görsel');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension = $baslik . '-Görsel-1.' . $extension; //  adını ve uzantısını birleştir
                $filePath = $file->storeAs('News', $fileNameWithExtension, 'public'); // "public" diskini kullanarak  klasöre kaydet
            } else {
                return redirect()->back()->with('warning', 'Görsel dosyası seçilmedi.');
            }
            if ($request->hasFile('görsel2')) {
                $file = $request->file('görsel2');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension2 = $baslik . '-Görsel-2.' . $extension; //  adını ve uzantısını birleştir
                $filePath = $file->storeAs('News', $fileNameWithExtension2, 'public'); // "public" diskini kullanarak  klasöre  kaydet
                $fileNameWithExtension2='/storage/news/' . $fileNameWithExtension2;
            } else {
                $fileNameWithExtension2 = ''; 
            }
            if($request->input('linkType') === 'harici'){
                $content='';
            }else {
                $content=$request->content;
            }
            News::create([
                'baslik' => $request->baslik,
                'kisa_aciklama' => $request->kisa_aciklama,
                'aciklama' => $content,
                'tarih' => $request->tarih,
                'link' => $request->link,
                'görsel' => '/storage/news/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
                'görsel2'=>$fileNameWithExtension2,
                'meta_title'=>$request->meta_title,
                'meta_description'=>$request->meta_description,
                'meta_keywords'=>$request->meta_keywords,
            ]);
            return redirect()->route('news.index')->with('success', 'Haber ekleme işlemi başarılı.');
        } catch (\Throwable $th) {
           return view('News.create')->with('warning', 'Haber ekleme işleminde bir hata oluştu.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $new=News::where('id',$id)->firstOrFail();
        return view('News.edit',compact('new'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $baslik = $request->baslik;
        $baslik = preg_replace('/[^A-Za-z0-9\-]+/', '_', $baslik);
        try {
            $validatedData = $request->validate([
                'baslik' => 'required|string|max:150',
                'kisa_aciklama' => 'required|string|max:250',
                'tarih' => 'required|date',
                'link' => $request->input('linkType') === 'harici' ? 'required' : '',
                'görsel' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($request->input('linkType') === 'siteIci') {
                $validatedData = $request->validate([
                    'content' => 'required|string',
                    'meta_title'=>'required|string|max:250',
                    'meta_description'=>'required|string|max:500',
                    'meta_keywords'=>'required|string|max:250'
                ]);
            }
    
            $news = News::findOrFail($id);
        
            // Eğer yeni görsel seçildiyse
            if ($request->hasFile('görsel')) {
                $görsel = $request->file('görsel');
                $eskiGörselYolu = storage_path('app/public/News/' . $baslik.'-Görsel-1');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $baslik . '-Görsel-1.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/News', $görselAdi);
        
                // Veritabanındaki görsel adını güncelle
                $news->görsel = '/storage/news/' .$görselAdi;
            }
            if ($request->hasFile('görsel2')) {
                $görsel = $request->file('görsel2');
                $eskiGörselYolu = storage_path('app/public/News/' . $baslik.'-Görsel-2');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $baslik . '-Görsel-2.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/News', $görselAdi);
        
                // Veritabanındaki görsel adını güncelle
                $news->görsel2 = '/storage/news/' .$görselAdi;
            }
            
            // Diğer güncelleme işlemlerini gerçekleştirin
            $news->baslik = $request->baslik;
            $news->kisa_aciklama = $request->kisa_aciklama;
            $news->aciklama=$request->content;
            $news->tarih=$request->tarih;
            $news->link=$request->link;
            $news->meta_title=$request->meta_title;
            $news->meta_description=$request->meta_description;
            $news->meta_keywords=$request->meta_keywords;
            // Diğer alanları da güncelleyin
        
            // Veritabanında güncellemeyi kaydet
            $news->save();
        
            return redirect()->route('news.index')->with('success', 'Haber başarıyla güncellendi.');
        } catch (\Throwable $th) {
            return redirect()->route('news.index')->with('warning', 'Haber güncelleme işleminde hata oluştu.');
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $news = News::findOrFail($id);

        if ($news) {
            $news->delete();
            return redirect()->route('news.index')->with('success', 'Haber başarıyla silindi.');
        } else {
            return redirect()->route('news.index')->with('error', 'Haber bulunamadı.');
        }

    }
    public function status(int $id){
        $news=News::findOrFail($id);
        if ($news->status==0) {
            $news->status=1;
        }else {
            $news->status=0;
        }
        $news->save();
        return redirect()->route('news.index');
    }
    public function home_page_status(int $id){
        $news=News::findOrFail($id);
        if ($news->home_page_status==0) {
            $news->home_page_status=1;
        }else {
            $news->home_page_status=0;
        }
        $news->save();
        return redirect()->route('news.index');
    }
}
