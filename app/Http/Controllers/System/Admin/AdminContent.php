<?php

namespace App\Http\Controllers\System\Admin;

use App\Http\Requests\System\Category\AddCategory;
use App\Http\Requests\System\Category\UpdateCategory;
use App\Http\Requests\ValidationRequest;
use App\Library\ActionList\ActionContentPage;
use App\Models\Category;
use App\Models\Content;
use App\Models\All_themes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use View;
use function Psy\debug;

class AdminContent extends Controller
{
    public function index()
    {
        return redirect()->route('admin_main');
    }

    public function show_main()
    {
        return view('system.admin_page.admin_main');
    }

    public function displayFormAddCategory()
    {
        $arCategories=Category::orderBy('name','asc')->get();

        return view('system.admin_page.content.categories.display_from_add_category',compact('arCategories'));
    }

    public function displayListSubContent($id)
    {
        //Получает массив подкатегорий, в зависимости какую категорию выбрали
        $arSubCategory=Category::where('parent_id',$id)->get();

        //Получаем массив конетента, в зависимости какую категорию выбрали
        $arContent=Category::find($id)->content;

        return view('system.admin_page.content.list_sub_content',compact('arSubCategory','arContent','id'));
    }

    public function displayListCategories()
    {
        $aRcategories = Category::where('parent_id',null)->orderBy('name')->get();

        return view('system.admin_page.content.mainCategories.list_main_categories', compact('aRcategories'));
    }

    public function displayFormUpdateCategory($id)
    {
        $arCategory=Category::find($id);
        $arUser=$arCategory->user;

        return view('system.admin_page.content.categories.detail_category',compact('arCategory','arUser'));
    }

    public function updateCategory(UpdateCategory $request,$id)
    {
        if($request->has('checkbox'))
        {
            Category::where('id',$id)->update([
                'name'=>$request->input('name_category'),
                'active'=>true
            ]);
        }else
            Category::where('id',$id)->update([
                'name'=>$request->input('name_category'),
                'active'=>false
            ]);

        return redirect()->route('list_categories');
    }

    public function show_setting()
    {
        $all_dir_in_template = array();

        //Просматриваем, какие папки есть в папке "template"
        $dir = opendir(resource_path('/views/template'));
        while ($file = readdir($dir)) {
            //Кроме созданных юзером необходимые файлы, отображаются другие, невидимые папки
            //Исключаем ненужные папки, а нежные запихивываем в массив "array_push"
            if ($file != "." && $file != "..")
            {
                //Запихивает в массив $all_dir_in_template найденные папки
                array_push($all_dir_in_template, $file);
            }
        }

        //Если в папке "template" всё таки есть папки
        if (count($all_dir_in_template) > 0) {
            foreach ($all_dir_in_template as $user_template)
            {
                //Проходит по всем найденным папкам и проверет на наличие неообходимых файлов
                if (file_exists(resource_path('/views/template/' . $user_template . '/description.json')) &&
                    file_exists(public_path('/template/' . $user_template . '/public/screen.jpg')) &&
                    View::exists('template.' . $user_template . '.header')) {
                    $json_data = json_decode(file_get_contents(resource_path("/views/template/" . $user_template . "/description.json")), true);

                    //Если в json есть необходимые поля
                    if (array_key_exists('theme', $json_data) && array_key_exists('author', $json_data) && array_key_exists('desc', $json_data))
                    {
                        //Проевряет на наличие уже созданной строки в таблице по аттрибуту "name_dir"
                        $all_theme = All_themes::where('name_dir', $user_template)->first();
                        if ($all_theme == null)
                        {
                            //Если нет такой темы, то записывается в таблицу
                            $all_theme = new All_themes;
                            $all_theme->name_dir = $user_template;
                            $all_theme->name_theme = $json_data['theme'];
                            $all_theme->name_author = $json_data['author'];
                            $all_theme->description_theme = $json_data['desc'];
                            $all_theme->use_theme = false;

                            $all_theme->save();
                        }
                        else
                        {
                            //Если есть такая тема, то обновляет данные в таблице
                            All_themes::where('id', $all_theme->id)->update([
                                'name_theme' => $json_data['theme'],
                                'name_author' => $json_data['author'],
                                'description_theme' => $json_data['desc']
                            ]);
                        }
                    }
                }
            }
            //Проверят, а были удалены некоторые темы, если да, то удаляет эту тему в таблице
            foreach (All_themes::all() as $value) {
                if (!in_array($value->name_dir, $all_dir_in_template))
                    All_themes::destroy($value->id);
            }

            return view('system.admin_page.admin_setting', [
                'error' => false,
                'all_themes' => All_themes::all()
            ]);
        }

        //если нет таких файлов
        return view('system.admin_page.admin_setting', [
            'error' => true,
        ]);
    }

    /**
     * Изменение темы
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function change_theme(Request $request)
    {
        All_themes::where('use_theme', 1)->update(['use_theme' => 0]);

        All_themes::where('id', $request->input('theme'))->update(['use_theme' => 1]);

        return redirect()->back();
    }

    public function displayAllContent($id)
    {
        $aRSelected_category = Category::where('id',$id)->first()->content()->paginate(20);

        return view('system.admin_page.content.contents.list_content', compact('aRSelected_category','id'));
    }

    public function addCategory(AddCategory $request)
    {
        //Сохраняет новую категорию
        $category=new Category();
        $category->name=$request->input('name_category');
        $category->active=true;
        $category->parent_id=$request->input('parent_category');
        $category->user_id=Auth::id();

        $category->save();

        return redirect()->route('list_categories');
    }

    public function displayFormContent($id)
    {
        return view('system.admin_page.content.contents.form_add_content',compact('id'));
    }

    public function addContent(ValidationRequest $request,$id)
    {
        $category=Category::find($id);
        $content=new Content([
            'title'=>$request->input('title'),
            'active'=>1,
            'user_id'=>Auth::id(),
            'content'=>$request->input('content'),
        ]);

        $category->content()->save($content);

        return redirect()->route('list_sub_content',$id);
    }

    public function detailContent($idCategory,$idContent)
    {
        $id=$idCategory;
        $arContent=Content::where('id',$idContent)->first();

        //Выбирает юзера, который создал данную запись
        $user=$arContent->user;

        return view('system.admin_page.content.contents.detail_content',compact('arContent','id','user'));
    }

    public function updateContent(ValidationRequest $request, $idCategory, $idContent)
    {
        if($request->has('checkbox'))
        {
            Content::where('id',$idContent)->update([
                'title'  =>$request->input('title'),
                'active'  =>true,
                'content'=>$request->input('content')
            ]);
        }else{
            Content::where('id',$idContent)->update([
                'title'  =>$request->input('title'),
                'active'  =>false,
                'content'=>$request->input('content')
            ]);
        }

        return redirect()->route('list_sub_content',$idCategory);
    }

    public function actionList(Request $request)
    {
        ActionContentPage::actionList($request->except('_token'));

        return redirect()->back();
    }
}
