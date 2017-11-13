<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
	private $entitiesNeeded = 100;
	private $puppyTypes;
	private $kittenFur;
	private $matches;
	
	public function __construct(\App\Services\MatchServiceInterface $matches) {
		$this->puppyTypes = config('globals.puppyTypes');
		$this->kittenFur = config('globals.kittenFur');
		$this->matches = $matches;
	}
	
	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    for($a=0; $a<$this->entitiesNeeded; $a++)
	    {
		    if($a == 0){
			    $userID = factory(\App\User::class)->create([
				    'name'=>'Andrey Naumoff',
				    'email'=>'admin@gmail.com',
				    'password'=>bcrypt('secret')
			    ])->id;
		    }else{
			    $userID = factory(\App\User::class)->create()->id;
		    }
		
			$this->createKitten($userID);
			
		    $this->createPuppy($userID);
	    }
	    $this->saveMatchesToRedis();
    }
    
    #region SERVICE METHODS
    private final function createKitten($userID)
    {
	    $kittenAnimalID = factory(\App\Animal::class)->create([
		    'owner_id'=>$userID,
		    'type'=>'kitten',
		    'photo'=>$this->kittensPhotos()[rand(0, count($this->kittensPhotos())-1)],
	    ])->id;
	
	    factory(\App\Kitten::class)->create([
		    'animal_id'=>$kittenAnimalID,
		    'fur'=>$this->kittenFur[rand(0,count($this->kittenFur)-1)]
	    ]);
    }
    
    private final function createPuppy($userID)
    {
	    $puppyAnimalID = factory(\App\Animal::class)->create([
		    'owner_id'=>$userID,
		    'type'=>'puppy',
		    'photo'=>$this->puppiesPhotos()[rand(0, count($this->kittensPhotos())-1)],
	    ])->id;
	
	    factory(\App\Puppy::class)->create([
		    'animal_id'=>$puppyAnimalID,
		    'type'=>$this->puppyTypes[rand(0,count($this->puppyTypes)-1)],
	    ]);
    }
	
	private final function kittensPhotos()
	{
		$files = Storage::files('/public/kittens');
		return $files;
	}
	
	private final function puppiesPhotos()
	{
		$files = Storage::files('/public/puppies');
		return $files;
	}
	
	private final function saveMatchesToRedis()
	{
		$this->matches->compileMatchMap();
		$this->matches->saveMatchMap();
		
	}
	#endregion
}
