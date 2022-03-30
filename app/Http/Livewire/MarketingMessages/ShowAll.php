<?php

namespace App\Http\Livewire\MarketingMessages;

use App\Models\Location;
use App\Models\MarketingMessage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;
    
    private $pagination = 10;
    public $filter = [
        "date_from" => "",
        "date_to" => "",
        "location" => "0"
    ];

    public $message = [
        "date" => '',
        "viber" => '',
        "sms" => '',
        "letters" => '',
        "location_id" => '0'
    ];
    public $createModalVisible = false;
    public $isEdit = false;
    public $messageToUpdate = null;

    private function fetch(){
        $messages = new MarketingMessage();

        if($this->filter["date_from"] != ''){
            $messages = $messages->where('sent_date', '>=', $this->filter["date_from"]);
        }

        if($this->filter["date_to"] != ''){
            $messages = $messages->where('sent_date', '<=', $this->filter["date_to"]);
        }

        if($this->filter["location"] != 0){
            $messages = $messages->where('location_id', $this->filter["location"]);
        }

        return $messages->orderBy('sent_date', 'desc')->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function showCreateModal($message = null){
        if($message){
            $this->isEdit = true;
            $this->messageToUpdate = $message;
            $this->message = [
                "sent_date" => $message["sent_date"],
                "viber" => $message["viber"] ?? '',
                "sms" => $message["sms"] ?? '',
                "letters" => $message["letters"] ?? '',
                "location_id" => $message["location_id"] ?? ''
            ];
        } else {
            $this->isEdit = false;
        }
        $this->createModalVisible = true;
    }

    public function cancelCreate(){
        $this->resetForm();
        $this->createModalVisible = false;
    }

    public function submitForm(){
        if($this->isEdit){
            $this->updateMessage();
        } else {
            $this->createMessage();
        }
    }

    public function createMessage(){
        Validator::make($this->message, [
            'sent_date' => ['required', 'date'],
            'viber' => ['integer'],
            'sms' => ['integer'],
            'letters' => ['integer'],
        ], [
            'sent_date.required' => 'Datum je obavezan.',
            'sent_date.date' => 'Datum je u pogrešnom formatu.',
            'integer' => 'U polju mora biti celobrojna vrednost.'
        ])->validate();

        foreach($this->message as $field => $value){
            if(empty($value)){
                unset($this->message[$field]);
            }
        }

        MarketingMessage::create($this->message);

        $this->resetForm();
        $this->createModalVisible = false;
        $this->dispatchBrowserEvent('success', ['message' => 'Uspešno dodate poruke!']);
    }

    public function updateMessage(){
        $message = MarketingMessage::find($this->messageToUpdate["id"]);

        Validator::make($this->message, [
            'sent_date' => ['required', 'date'],
            'viber' => ['integer'],
            'sms' => ['integer'],
            'letters' => ['integer'],
            'location_id' => ['required', 'not_in:0', 'exists:locations,id']
        ], [
            'sent_date.required' => 'Datum je obavezan.',
            'sent_date.date' => 'Datum je u pogrešnom formatu.',
            'integer' => 'U polju mora biti celobrojna vrednost.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        foreach($this->message as $field => $value){
            if(empty($value)){
                unset($this->message[$field]);
            }
        }

        $message->update($this->message);

        $this->resetForm();
        $this->isEdit = false;
        $this->messageToUpdate = null;
        $this->createModalVisible = false;
        $this->dispatchBrowserEvent('success', ['message' => 'Uspešno izmenjene poruke!']);
    }

    public function resetForm(){
        $this->message = [
            "date" => '',
            "viber" => '',
            "sms" => '',
            "letters" => '',
            "location_id" => '0'
        ];
    }

    public function render()
    {
        return view('livewire.marketing-messages.show-all', [
            "messages" => $this->fetch(),
            "locations" => Location::all()
        ]);
    }
}
