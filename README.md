
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

 * run install .sql and copy config.sample.php to config.php

 * conigue config.php to use the respective database credentials

 * run the deamon from the command line <pre>./agentinferd</pre>

 * open up the chat_box client in a browser <pre>./clients/chat_box/index.php</pre>

 * Recognized commands
    
    * SHUTDOWN: halt the machine and take a snapshot of the state

####Some key components of the inference engine:

* State

  * the state is a store of all of the current data being processed. 
  * it provides context that modules can be dependent upon.

* Sense of Environment

  * the default environment is a virtual agent using the chat box

* Self Actualization

  * the agent should keep memory of its successes and failures and evolve upon these

* Randomness

  * should use novel search algorithms to promote exploration and evolution

### Modules

* each knowledge based module has a database and a set of policies

* modules use the obsever/subject paradigm to promote decoupling

##### Core Modules


#### READ WRITE 

* handle IO processing between the client and the core IO Buffer

* should have alot of oberserers attached

#### Emotion Module

* identifies emotions and associates them to self actualization, state and sense of environment

* apply emotions to the inference of subscribing modules.

#### Language Module

* should be subscribed to emotion module if it exists.

#### Memory Object

* should keep details memories about nouns to refer to for later decision making etc.
