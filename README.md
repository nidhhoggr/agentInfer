
<pre>
    _                    _   ___        __           
   / \   __ _  ___ _ __ | |_|_ _|_ __  / _| ___ _ __ 
  / _ \ / _` |/ _ \ '_ \| __|| || '_ \| |_ / _ \ '__|
 / ___ \ (_| |  __/ | | | |_ | || | | |  _|  __/ |   
/_/   \_\__, |\___|_| |_|\__|___|_| |_|_|  \___|_|   
        |___/                                        
</pre>

## AgentInfer

###RELEASE 0.0.2

* based on an inference engine of modular knowledge based components.

* implentation in php 5.3 and Mysql

####Instructions

 * run install .sql
 
 * copy config.sample.php to config.php and conigue config.php to use the respective database credentials

 * navigate to clients/cmd and run ./stream from shell.

 * Recognized commands
    
    * STARTUP: boot the machine from the chat client

    * SHUTDOWN: halt the machine and take a snapshot of the state

####Some key components of the inference engine:

* State

  * the state is a store of all of the current data being processed. 
  * it provides context that modules can be dependent upon.

* Fingerprint

  * stores unique values about the agent such as name age etc. A way to decouple from the fact storag.

* Sense of Environment

  * the default environment is the sreaming cmd php-cli script which processes STDIN and STDOUT from the shell

* Self Actualization

  * the agent should keep memory of its successes and failures and evolve upon these

* Randomness

  * should use novel search algorithms to promote exploration and evolution

### Modules

* each knowledge based module has a database and a set of policies

* modules use the obsever/subject paradigm to promote decoupling

##### Core Modules


#### READ WRITE 

* handles IO processing between the client and the core IO Buffer

* should have a lot of observers attached

* uses NLP dependency to tokenize sentence and convery meaning and context of sentence.

* Delegate processing to memory for answering questions


#### Emotion Module

* identifies emotions and associates them to self actualization, state and sense of environment

* apply emotions to the inference of subscribing modules.

#### Language Module

* should be subscribed to emotion module if it exists.

#### Memory Object

* should keep detailed memories about nouns to consult for later decision making etc.

* stores questions and answers and refers to them when processing input

* in addition to answering question possibly from memory object fact table, it should also refer to it's own fingerprint
