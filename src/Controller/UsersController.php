<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');

        $this->Auth->allow(['register', 'logout']);
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            // set default identity as general
            $user->identity = 'general';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('You have been registered.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Unable to finish you register.'));
        }
        $this->set('user', $user);
    }

    public function password()
    {
        $user = $this->Users->findById($this->Auth->user('id'))->firstOrFail();
        $this->set(compact('user'));

        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to change your password.'));
        }
    }

    public function login()
    {
        // if user is in login state, redirect to menu page
        if($this->Auth->user()) {
            return $this->redirect('/menus'); 
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // if user logins in login page, redirect to menu page after login
                if($this->Auth->redirectUrl() == '/') {
                    return $this->redirect('/menus');
                }
                // or if user are sign out due to a longer idle state, redirect to user's
                // original page after login
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function index()
    {
        $users = $this->Paginator->paginate($this->Users->find());
        $this->set(compact('users'));
    }

    public function view($username)
    {
        $user = $this->Users->findByUsername($username)->firstOrFail();
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your user.'));
        }
        $this->set('user', $user);
    }

    public function edit($id)
    {
        $user = $this->Users->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your user has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your user.'));
        }

        $this->set('user', $user);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->findById($id)->firstOrFail();
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('User {0} has been deleted.', $user->username));
            return $this->redirect(['action' => 'index']);
        }
    }
}