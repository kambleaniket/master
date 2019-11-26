<?php
namespace App\Controller;
require 'vendor/autoload.php';
// require_once __DIR__ . '/vendor/autoload.php';
use App\Controller\AppController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use mpdf\mpdf\Mpdf;
use Cake\ORM\TableRegistry;

/**
 * Uploads Controller
 *
 *
 * @method \App\Model\Entity\Upload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */



class UploadsController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
        
        // Load Files model
        $this->loadModel('Files');
        
        // Set the layout
        // $this->layout = 'frontend';
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $uploadData = '';
        if ($this->request->is('post')) {
            if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $fileSize = round($this->request->data['file']['size'] / 1024 , 2);

                $uploadPath = 'webroot/uploads/files/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->size = $fileSize;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
                        $this->Flash->success(__('File has been uploaded and inserted successfully.'));

                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'));
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'));
                }
            }else{
                $this->Flash->error(__('Please choose a file to upload.'));
            }
            
        }
        $this->set('uploadData', $uploadData);
        
        $files = $this->Files->find('all', ['order' => ['Files.created' => 'DESC']]);
        $filesRowNum = $files->count();
        $this->set('files',$files);
        $this->set('filesRowNum',$filesRowNum);
    }

   

    /**
     * View method
     *
     * @param string|null $id Upload id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $upload = $this->Uploads->get($id, [
            'contain' => []
        ]);

        $this->set('upload', $upload);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $upload = $this->Uploads->newEntity();
        if ($this->request->is('post')) {
            $upload = $this->Uploads->patchEntity($upload, $this->request->getData());
            if ($this->Uploads->save($upload)) {
                $this->Flash->success(__('The upload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The upload could not be saved. Please, try again.'));
        }
        $this->set(compact('upload'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Upload id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $upload = $this->Uploads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $upload = $this->Uploads->patchEntity($upload, $this->request->getData());
            if ($this->Uploads->save($upload)) {
                $this->Flash->success(__('The upload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The upload could not be saved. Please, try again.'));
        }
        $this->set(compact('upload'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Upload id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $upload = $this->Uploads->get($id);
        if ($this->Uploads->delete($upload)) {
            $this->Flash->success(__('The upload has been deleted.'));
        } else {
            $this->Flash->error(__('The upload could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function createXls()
    {
        $this->autoRender= false;
        $this->loadModel('Countries');
        $xlsFolderPath = 'webroot/xlsFolder/';
       
        // $header_row_array = ['ID', 'SortName', 'Name','Phonecode'];
        $countries = $this->Countries->find('all')->toArray();
        $country = array();
        foreach ($countries as $key => $value) {
            
            $country[] = $value->id;
            $country[] = $value->sortname;
            $country[] = $value->name;
            $country[] = $value->phonecode;
            
        }
        $spreadsheet = new Spreadsheet();
        // $spreadsheet->setActiveSheetIndex(0)->fromArray( $header_row_array ,NULL , 'A1');
        $row = 1;
        $col = 1;
        
        foreach ($country as $value) {
            if ($col > 4) {
                $col = 1;
                $row++;
            
             }  

            $spreadsheet->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $value);
            $col++;    
        }
        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(1)->fromArray( $header_row_array ,NULL , 'A1');
        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsFolderPath . 'Count.xlsx');
        return $this->redirect(['action' => 'index']);
            
    }

    public function createpdf(){
        $this->autoRender = false;
        $stylesheet = file_get_contents('webroot/css/mpdf.css');
        $pagedata = $_POST['pagedata'];
        $pdfFolderPath = 'webroot/xlsFolder/';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($pagedata,\Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output($pdfFolderPath . 'pdffile.pdf','F');

    }
    public function writedatatable(){
        $uploadFile = "";
        if ($this->request->is('post')) {
             if(!empty($this->request->data['file']['name'])){        
                $fileName = $this->request->data['file']['name'];
                $fileRoot = './webroot/xlsFolder/';
                $filePath = $fileRoot.$fileName;
                move_uploaded_file($this->request->data['file']['tmp_name'],$filePath);
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                // $rowcount = count($sheetData);
                // $colcount = (count($sheetData[0]));
                $demosTable = TableRegistry::getTableLocator()->get('Demos');
                    foreach ($sheetData as $key => $value) {
                               $demo = $demosTable->newEntity();
                               $sr = $sheetData[$key][0];
                               $sortname = $sheetData[$key][1];
                               $name = $sheetData[$key][2];
                               $phonecode = $sheetData[$key][3];
                               $demo->sr = $sr;
                               $demo->sortname =$sortname;
                               $demo->name =$name;
                               $demo->phonecode =$phonecode;
                               $demosTable->save($demo);
                           }      
               $this->Flash->success(__('File has been uploaded and inserted successfully.'));
               
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'));
                }
            }
            else
            {
                $this->Flash->error(__('Please choose a file to upload.'));
            }
            
         $this->set(compact('uploadFile'));    

    }

    public function searchfields(){
        $this->loadModel('Countries');
        if($this->request->is(['post'])) {
            $searchFields = $_POST['searchField'];
            $countries = $this->Countries->find()
                                ->where(['id '=> $searchFields])->toArray();
        }
        else
        {
            $countries = $this->Countries->find()->toArray();
            $this->set(compact('countries'));    
        }
        
    }
        
}
