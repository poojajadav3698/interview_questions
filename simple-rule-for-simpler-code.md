You may heard a term called `Object Calisthenics`, it is not something you would
need to scare of. But it simply refers to set of coding standards and guidelines
that we need to follow when producing better software applications. Will discus 
three main factors that we need to consider when we write a piece of code. 
By following these rules your code would get more readable and maintainable 
and also it would affect the quality of the software that you produce. 

# Three main important factors to consider when you write new code

### 1. No Abbreviations

Do not abbreviate your code, as a developer, even in early stage you may break
this one at some point or another. Here is what I mean, Have you ever done
something like this, imagine you had a translator class and you wrote like
follows:

```php
<?php

class Trnsltr
{

}
```
Never under any circumstances create a class name or any variable name like
this. It is interesting you wonder why you would do this? As a beginner
developer we feel this need to abbreviate everything including class names,
variables, etc. So literarily there is zero benefit to use an abbreviations
like this, therefor don't do it.

Correct way is to writing it out manually, once it go to your mussel memory it
fixed.

```php
<?php

class Translator
{

}
```

Lets take another example of writing foreach this is also common mistake that
we all did when we first getting into development

```php
<?php

foreach($people as $x)
{
  .
  .
  .
  $x->name

}
```

Lets say you wrote the above code in six months ago, and code in between
foreach has been grown to few more lines, it may take you just a seconds to
remember what $x is equal to. So why bother naming $x it as real name like
$person since our newer IDE's can easily auto complete these for us. So once
again there is zero reason to abbreviate.

What about other offenders, we pointed out class names and variables but this
will also apply to method names as well. Lets say you have `UserRepository`
class. On that class we have method named `fetch` to fetch user information by
their billing ID. (It is not by their user ID)

```php
<?php

class UserRepository
{
  public function fetch($billingId)
  {
    ...
  }
}
```

Imagine you come to the project from year or two and you may get confuse by this
method. Because it looks like a fetch method to get user information by ID, but
the method it self needs billing ID.

The problem of the above method is that the `fetch` is sort of like an
abbreviation. What we really doing here is fetch user information by billing ID
so we could write code more meaning full way as follows:

```php
<?php

class UserRepository
{
  public function fetchByBillingId($id)
  {
    ...
  }
}
```

### 2. Do not use Else

Is it possible that the else condition within a method of yours is either
unnecessary or redundant? Yes it might be!

Consider following code snippet, imagine that your company has some Rules
that says we only work on Friday and we believe in this so much that we do not
allow you to post to the company blog if it is on Friday.   

```php
<?php

public function store()
{
  $input = Request::all();
  $validation = Validator::make($input, ['name' => 'required']);

  if (date('l') !== 'Friday')
  {
    if ($validation->passes())
    {
      Post::create($input);

      return Redirect::home();
    }
    else
    {
      return Redirect::back()->withInput()->withErrors($validation);
    }
  }
  else
  {
    throw new AcmeException('We do not work on Fridays!');
  }
}
```

Let see how we might get improve above code. Because notice that we already
have a simple method with a few branches (if/else) that we need to understand
each and every time when we read the code.

Consider the `if ($validation->passes())` condition if it gets `true` it will
return immediately. Those situation when you return within one conditional
usually that means that `else ` is get redundant. That means we could remove
the else condition and modify the code like follows:

```php
<?php

public function store()
{
  $input = Request::all();
  $validation = Validator::make($input, ['name' => 'required']);

  if (date('l') !== 'Friday')
  {
    if ($validation->passes())
    {
      Post::create($input);

      return Redirect::home();
    }

    return Redirect::back()->withInput()->withErrors($validation);
  }
  else
  {
    throw new AcmeException('We do not work on Fridays!');
  }
}
```

Also for the above scenario you could also think of more like
`defensive programming approach`, so in this above example we would have check
if the validation has failed first. That way our happy path is always at the
bottom of the code. So we could modify the code as follows:

```php
<?php

public function store()
{
  $input = Request::all();
  $validation = Validator::make($input, ['name' => 'required']);

  if (date('l') !== 'Friday')
  {
    if ($validation->failed())
    {
      return Redirect::back()->withInput()->withErrors($validation);
    }

    Post::create($input);

    return Redirect::home();
  }
  else
  {
    throw new AcmeException('We do not work on Fridays!');
  }
}
```

We could use our `defensive approach` for the top level if statement as well.
So we can even modify our code as follows:


```php
<?php

public function store()
{
  $input = Request::all();
  $validation = Validator::make($input, ['name' => 'required']);

  if (date('l') === 'Friday')
  {
    throw new AcmeException('We do not work on Fridays!');
  }

  if ($validation->failed())
  {
    return Redirect::back()->withInput()->withErrors($validation);
  }

  Post::create($input);

  return Redirect::home();
}
```

So finally after couple of tweaks here we have successfully removed two else
conditionals and we have decreased the indentation. Which is nearly always an
indication that you are in the right track.

### 3. One level of indentation

This guide line is very important. Once you really forced your self to follow
it, you would definitely improve the quality of the code that you are writing.

One level of indentation? you may feel that is impossible but may be there
would be lot of changes that we could adopt this rule into our code. Lets write
an example for that.

Imagine that we have kind of BackAccount collection class and Account class.
Assume that we would need to give our self a way to filter down all of our
`active` Accounts according to some specific type (saving/checking).  

```php
<<?php

class BackAccount
{

  protected $accounts;

  function __construct($accounts)
  {
    $this->accounts = $accounts;
  }

  public function filterBy($accountType)
  {
    $filtered = [];

    foreach($this->accounts as $account)
    {
        if ($account->type() == $accountType)
        {
          if ($account->isActive())
          {
            $filtered[] = $account;
          }
        }
    }
    return $filtered;
  }
}

class Account
{

  protected $type;

  private function __construct($type)
  {
    return $this->type = $type;
  }

  /**
   * In order to open an account
   * you must use this method.
   */
  public static function open($type)
  {
    return new static($type);
  }

  public function type()
  {
    return $this->type;
  }

  public function isActive()
  {
    // for this example all account are `active`
    return true;
  }

}

$accounts = [
  Account::open('checking'),
  Account::open('saving'),
  Account::open('saving'),
  Account::open('checking')
];

$accounts = new BackAccount($accounts);

$saving = $accounts->filterBy('checking');

var_dump($saving);
````
Output:
```sh
array(2) {
  [0]=>
  object(Account)#1 (1) {
    ["type":protected]=>
    string(8) "checking"
  }
  [1]=>
  object(Account)#4 (1) {
    ["type":protected]=>
    string(8) "checking"
  }
}
```

Using above code, if you could pay attention to the indentation of the
`filterBy` method you would see that we already have 3 level of indentation.
Lets try to improve `filterBy` method to follow our `One Level Of indentation`
rule.

First thing to do is to check whether you have nested foreach statements or
conditional statements. If so we could start work from inside out. (So the
deepest indentation and slowly work your way to out)

If you closely look our 2nd and 3rd level of indentation, It just checks if
the account type is the one we requested and also the account is active then
update this filtered array. So that means we could probably combine both
if conditions together.

```php
public function filterBy($accountType)
{
  $filtered = [];

  // 0 indentation
  foreach($this->accounts as $account)
  {
      // 1 indentation
      if ($account->type() == $accountType && $account->isActive())
      {
        // 2 indentation
        $filtered[] = $account;
      }
  }
  return $filtered;
}
```

And we have now removed a one level of indentation. But next we could optimize
the if condition bit more. The reason is when you come back to this code
snippet in 6 months from now you would have to parse what this does
to your head. You would need to go over it and say "Alright if the account type
is what we passed in and also the account is active than I could move on." that
way to too much of processing for us to do.       

So one of the practice we could do is just extract the condition into a method,
and now the key here is to write meaningful method as best as you can. So in
this case we could image `Is of the type` so we could name the method like
`isOfType`. By extracting the condition into a method it could be re-use in
the class if it necessary.

```php
public function filterBy($accountType)
{
  $filtered = [];

  // 0 indentation
  foreach($this->accounts as $account)
  {
      // 1 indentation
      if ($this->isOfType($accountType, $account))
      {
        // 2 indentation
        $filtered[] = $account;
      }
  }
  return $filtered;
}
```

The above refactoring does nothing for our indentation, but it does a lot for
code readability which is equally as important. Still we have 2 level of
indentation, what else we could do for that? Well if you see the foreach we are
just filtering through our accounts and returning  a sub set of them
(only the once that has the type we specified.) May be the foreach is not the
right choice for that, may be we should use php `array_filter` function that is
specifically what it was designed for. So lets make sure that we use it.

```php
public function filterBy($accountType)
{
  return array_filter($this->accounts, function ($account) use ($accountType) {
    return $this->isOfType($accountType, $account);
  });
}
```

Here is the complete code:

```php
<?php

class BackAccount
{

  protected $accounts;

  function __construct($accounts)
  {
    $this->accounts = $accounts;
  }

  public function filterBy($accountType)
  {
    return array_filter($this->accounts, function ($account) use ($accountType) {
      return $this->isOfType($accountType, $account);
    });
  }

  private function isOfType($accountType, $account)
  {
    return ($account->type() == $accountType && $account->isActive());
  }

}

class Account
{

  protected $type;

  private function __construct($type)
  {
    return $this->type = $type;
  }

  /**
   * In order to open an account
   * you must use this method.
   */
  public static function open($type)
  {
    return new static($type);
  }

  public function type()
  {
    return $this->type;
  }

  public function isActive()
  {
    // for this example all account are `active`
    return true;
  }

}

$accounts = [
  Account::open('checking'),
  Account::open('saving'),
  Account::open('saving'),
  Account::open('checking')
];

$accounts = new BackAccount($accounts);

$saving = $accounts->filterBy('saving');

var_dump($saving);

```

Output:
```sh
array(2) {
  [0]=>
  object(Account)#1 (1) {
    ["type":protected]=>
    string(8) "checking"
  }
  [1]=>
  object(Account)#4 (1) {
    ["type":protected]=>
    string(8) "checking"
  }
}
```

Now check it out, we have achieved exact same end result but we have exactly
one level of indentations. But originally we had 3 levels of indentations. Further
imagine if within those 3 levels of indentations we had some else statements
where we have some situations we were branching our logic. All of that stuff
specially in 6 months from now begins to add up and your code becomes lengthier.
As a result that would become difficult to take in.

So now when by following this approach where we are super ultra
sensitive to this idea of deep indentation levels we actually improved the
the design and the readability of our class and the process. So remember it is
not just about achieving some arbitrary rule, it is about finding little
technique that help you to improve your software.  


**Happy coding !
